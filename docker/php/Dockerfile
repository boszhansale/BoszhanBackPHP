FROM php:8.1-fpm

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    jpegoptim \
    optipng \
    pngquant \
    gifsicle \
    webp
RUN docker-php-ext-install pdo_mysql bcmath gd zip mbstring exif pcntl

RUN pecl install redis && docker-php-ext-enable redis

COPY .. .

RUN chmod -R 777 storage bootstrap/cache

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN composer install --no-interaction --prefer-dist --no-suggest --no-progress --optimize-autoloader

CMD php artisan serve --host=0.0.0.0 --port=8000

