FROM php:7-apache

COPY *.html /var/www/html/
COPY Buen_Provecho_Taco_Shack.* /var/www/html/
COPY assets /var/www/html/assets
COPY images /var/www/html/images
COPY secret_files /var/www/html/secret_files
RUN chmod 444 /var/www/html/images/*
RUN chmod 777 /var/www/html/assets/*
RUN chmod 777 /var/www/html/secret_files
RUN chmod 444 /var/www/html/Buen_Provecho_Taco_Shack.*

RUN apt update
RUN apt install python3 -y
RUN apt install npm -y
RUN npm install type.js
COPY create_directories.py /var/www/html/