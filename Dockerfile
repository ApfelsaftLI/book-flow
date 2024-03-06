FROM php:8.3.4RC1-apache

WORKDIR /var/www/html

COPY src/ .

RUN docker-php-ext-install pdo_mysql

EXPOSE 80
