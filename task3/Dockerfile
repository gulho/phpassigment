FROM php:8.3-fpm

RUN apt update && apt install sqlite3

RUN docker-php-ext-install pdo

RUN pecl install xdebug && docker-php-ext-enable xdebug
