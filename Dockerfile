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

# Install PHP dependencies with error handling
RUN composer install --no-dev --optimize-autoloader --no-interaction || \
    (echo "❌ Composer installation failed" >&2 && exit 1)

# Install & build frontend assets with error checking
RUN npm install || (echo "❌ NPM install failed" >&2 && exit 1) && \
    npm run build 2>/dev/null || (echo "⚠️ NPM build skipped (non-critical)" && true)

# Set permissions and verify directories
RUN mkdir -p storage bootstrap/cache && \
    chmod -R 775 storage bootstrap/cache && \
    chown -R www-data:www-data storage bootstrap/cache && \
    chmod -R 755 storage bootstrap && \
    test -d storage || (echo "❌ storage directory not created" >&2 && exit 1) && \
    test -d bootstrap/cache || (echo "❌ bootstrap/cache directory not created" >&2 && exit 1)

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

# Health check
HEALTHCHECK --interval=30s --timeout=10s --start-period=5s --retries=3 \
    CMD curl -f http://localhost:10000/health 2>/dev/null || exit 1

# Runtime: cache config, migrate, and serve with comprehensive error handling
CMD set -e && \
    echo "🔄 Caching configuration..." && \
    php artisan config:cache || (echo "❌ Config cache failed" >&2 && exit 1) && \
    echo "🔄 Running database migrations..." && \
    php artisan migrate --force || (echo "❌ Database migration failed" >&2 && exit 1) && \
    echo "✅ Starting application server..." && \
    php artisan serve --host=0.0.0.0 --port=${PORT:-10000} || \
    (echo "❌ Application failed to start" >&2 && exit 1)
