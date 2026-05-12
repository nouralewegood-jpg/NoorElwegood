```dockerfile
FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    git \
    curl \
    unzip \
    zip \
    nodejs \
    npm \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev

RUN docker-php-ext-configure gd --with-freetype --with-jpeg

RUN docker-php-ext-install \
    pdo \
    pdo_sqlite \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    zip

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

RUN mkdir -p database
RUN touch database/database.sqlite

RUN composer install --no-dev --optimize-autoloader

RUN npm install
RUN npm run build || true

RUN chmod -R 775 storage bootstrap/cache database

RUN php artisan config:clear || true
RUN php artisan cache:clear || true
RUN php artisan key:generate --force || true
RUN php artisan migrate --force || true

EXPOSE 10000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=10000"]
```
