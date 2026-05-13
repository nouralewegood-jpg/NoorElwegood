# ─── Stage 1: Build ─────────────────────────────────────────────
FROM php:8.2-fpm-alpine AS builder

WORKDIR /var/www/html

# Install dependencies
RUN apk add --no-cache \
    curl \
    libpng-dev \
    libzip-dev \
    zip \
    unzip \
    sqlite \
    sqlite-dev \
    nodejs \
    npm

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_sqlite gd zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy project files
COPY . .

# Install PHP dependencies (production only)
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Install & build frontend assets
RUN npm install && npm run build

# ─── Laravel Build Commands (تنفذ مرة واحدة فقط) ─────────────
RUN php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache

# ─── Stage 2: Runtime ──────────────────────────────────────────
FROM php:8.2-cli-alpine

WORKDIR /var/www/html

# Install runtime dependencies only
RUN apk add --no-cache \
    libpng \
    libzip \
    sqlite \
    curl

# Copy from builder
COPY --from=builder /var/www/html /var/www/html

# Set permissions
RUN chmod -R 775 storage bootstrap/cache && \
    chown -R www-data:www-data storage bootstrap/cache

# SQLite database directory
RUN mkdir -p /var/www/html/database && \
    touch /var/www/html/database/database.sqlite && \
    chmod 664 /var/www/html/database/database.sqlite

ENV APP_ENV=production
ENV APP_DEBUG=false
ENV DB_CONNECTION=sqlite
ENV DB_DATABASE=/var/www/html/database/database.sqlite

EXPOSE 10000

# Runtime: فقط serve
CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=${PORT:-10000}
