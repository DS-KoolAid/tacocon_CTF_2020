FROM php:7-apache

COPY *.php /var/www/html/
COPY index.html /var/www/html/
COPY assets /var/www/html/assets
COPY images /var/www/html/images
RUN chmod 444 /var/www/html/images/*
