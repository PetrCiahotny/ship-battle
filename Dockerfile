FROM php:8.2-apache

# RUN docker-php-ext-install mysqli
RUN docker-php-ext-install pdo pdo_mysql
RUN apt-get update && apt-get -y install  mc
RUN chmod 777 /var/log
RUN a2enmod rewrite
