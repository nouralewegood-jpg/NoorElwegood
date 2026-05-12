FROM php:8.2-cli

RUN apt-get update && apt-get install -y \n    git unzip zip libpng-dev libjpeg62-turbo-dev \n    libfreetype6-dev libonig-dev libxml2-dev libzip-dev curl

RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - && apt-get install -y nodejs

RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install pdo pdo_mysql gd mbstring exif pcntl bcmath zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY . .

RUN npm install && npm run build
RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs

EXPOSE 8080

CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=${PORT}