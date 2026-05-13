FROM php:8.2-cli-alpine

WORKDIR /var/www/html

# Install system dependencies
RUN apk add --no-cache \
    curl \
    zip \
    unzip \
    libpng-dev \
    libzip-dev \
    postgresql-dev \
    nodejs \
    npm

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_pgsql gd zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy project files
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Install & build frontend assets
RUN npm install && npm run build

# Set permissions
RUN mkdir -p storage bootstrap/cache && \
    chmod -R 775 storage bootstrap/cache && \
    chown -R www-data:www-data storage bootstrap/cache

ENV APP_ENV=production
ENV APP_DEBUG=false

# Database configuration
ENV DB_CONNECTION=pgsql
ENV DB_HOST=${DB_HOST:-localhost}
ENV DB_PORT=${DB_PORT:-5432}
ENV DB_USERNAME=${DB_USERNAME:-postgres}
ENV DB_PASSWORD=${DB_PASSWORD:-secret}
ENV DB_DATABASE=${DB_DATABASE:-app}

EXPOSE 10000

# Runtime: cache config, migrate, and serve
CMD php artisan config:cache && php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=${PORT:-10000}
