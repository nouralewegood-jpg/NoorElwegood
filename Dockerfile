FROM php:8.2-apache

RUN apt-get update && apt-get install -y \n    git unzip zip libpng-dev libjpeg62-turbo-dev \n    libfreetype6-dev libonig-dev libxml2-dev libzip-dev

RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install pdo pdo_mysql gd mbstring exif pcntl bcmath zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs

RUN sed -i 's/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf
RUN a2enmod rewrite

RUN chown -R www-data:www-data storage bootstrap/cache

RUN sed -i 's/80/${PORT}/g' /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf

CMD php artisan migrate --force && apache2-foreground