FROM php:7-apache

COPY src/*.php /var/www/html/
COPY assets /var/www/html/assets
COPY images /var/www/html/images
RUN chmod 444 /var/www/html/images/*
RUN chmod 777 /var/www/html/assets/*
RUN docker-php-ext-install pdo pdo_mysql mysqli