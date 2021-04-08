FROM php:7.2-apache

RUN apt update && apt upgrade -y
RUN docker-php-ext-install mysqli pdo pdo_mysql

COPY ./src/ /var/www/html/
COPY ./thisFileIsSecretAndConfidential.txt /
