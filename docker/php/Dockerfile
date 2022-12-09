FROM php:8.1-fpm

RUN apt-get update
RUN apt-get -y upgrade

RUN docker-php-ext-install pdo pdo_mysql mysqli

RUN apt-get -y install libgmp-dev
RUN docker-php-ext-install gmp
