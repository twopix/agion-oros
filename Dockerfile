# Base stage
FROM php:8.2-fpm-alpine as composer_base

# Установка необходимых пакетов и расширений PHP
RUN apk add --no-cache \
        gettext \
        postgresql-dev \
        freetype-dev \
        libjpeg-turbo-dev \
        libpng-dev \
        icu-dev \
        libzip-dev \
        exiftool \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) pdo pdo_pgsql pgsql gd intl zip exif

# Установка Composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && php -r "unlink('composer-setup.php');"

# Копирование файлов приложения и установка зависимостей
WORKDIR /opt/apps/laravel
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist
COPY . .
RUN composer install --no-dev --prefer-dist \
    && composer update \
    && composer dump-autoload

# FPM stage
FROM composer_base as fpm
CMD ["/opt/apps/laravel/start-fpm"]

# Cron stage
FROM composer_base as cron
RUN echo "* * * * * cd /opt/apps/laravel && php artisan schedule:run" > ./laravel.cron \
    && crontab ./laravel.cron
CMD ["/usr/sbin/crond", "-l", "2", "-f"]

# Web server stage
FROM nginx:1.20-alpine as web
COPY public /opt/apps/laravel/public
WORKDIR /opt/apps/laravel/public
