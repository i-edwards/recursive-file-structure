FROM php:8.4-apache

RUN a2enmod rewrite

RUN apt-get update -y && apt-get install -y zip

RUN docker-php-ext-install pdo pdo_mysql

COPY --from=composer:2.8 /usr/bin/composer /usr/bin/composer
