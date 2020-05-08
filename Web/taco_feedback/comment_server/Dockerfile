FROM php:7-apache

COPY *.php /var/www/html/
COPY feedback.html /var/www/html/
COPY comments.html /var/www/
COPY assets /var/www/html/assets
COPY images /var/www/html/images
COPY comment_server-cron /etc/cron.d/
RUN chmod 644 /etc/cron.d/comment_server-cron
RUN chmod 444 /var/www/html/images/*
RUN chmod 777 /var/www/comments.html
RUN cp /var/www/comments.html /var/www/comments-gold.html
RUN chmod 777 /var/www/html/assets/*
RUN apt update && apt install -y cron;
RUN (crontab -l -u root; echo "*/2 * * * * cp /var/www/comments-gold.html /var/www/comments.html") | crontab
RUN crontab /etc/cron.d/comment_server-cron
RUN cron


