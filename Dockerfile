FROM php:8.2-fpm-alpine AS builder
WORKDIR /var/www/html
RUN apk add --no-cache curl libpng-dev libzip-dev zip unzip sqlite sqlite-dev nodejs npm
RUN docker-php-ext-install pdo pdo_sqlite gd zip
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
COPY . .
RUN composer install --no-dev --optimize-autoloader --no-interaction
RUN npm install && npm run build 2>/dev/null || true
RUN php artisan config:cache && php artisan route:cache && php artisan view:cache

FROM php:8.2-cli-alpine
WORKDIR /var/www/html
RUN apk add --no-cache libpng libzip sqlite curl
COPY --from=builder /var/www/html /var/www/html
RUN chmod -R 775 storage bootstrap/cache && \
    chown -R www-data:www-data storage bootstrap/cache
RUN mkdir -p /var/www/html/database && \
    touch /var/www/html/database/database.sqlite && \
    chmod 664 /var/www/html/database/database.sqlite
ENV APP_ENV=production
ENV APP_DEBUG=false
ENV DB_CONNECTION=sqlite
ENV DB_DATABASE=/var/www/html/database/database.sqlite
EXPOSE 10000
CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=${PORT:-10000}
