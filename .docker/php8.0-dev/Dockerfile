ARG PHP_VER

FROM php:${PHP_VER}-fpm-alpine

RUN apk update
RUN apk add --no-cache build-base
RUN apk add --no-cache autoconf
RUN apk add --no-cache automake

# curl for cmd
RUN apk add --no-cache curl

# php extensions

# mcrypt
RUN apk add --no-cache libmcrypt-dev
RUN pecl install mcrypt
RUN docker-php-ext-enable mcrypt

# bcmath
RUN docker-php-ext-install bcmath
RUN docker-php-ext-enable bcmath

# sockets
RUN docker-php-ext-install sockets
RUN docker-php-ext-enable sockets

# intl
RUN apk add --no-cache icu-dev
RUN docker-php-ext-install intl
RUN docker-php-ext-enable intl

# opcache
RUN docker-php-ext-install opcache
RUN docker-php-ext-enable opcache

# amqp
#RUN apk add --no-cache rabbitmq-c-dev
#RUN pecl install amqp
#RUN docker-php-ext-enable amqp

# redis
RUN pecl install redis
RUN docker-php-ext-enable redis

# zip
RUN apk add --no-cache libzip-dev
RUN docker-php-ext-install zip
RUN docker-php-ext-enable zip

# mysql
RUN docker-php-ext-install mysqli
RUN docker-php-ext-enable mysqli

# pdo_mysql
RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-enable pdo_mysql

# opcache
RUN docker-php-ext-install opcache
RUN docker-php-ext-enable opcache

#composer
ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_MEMORY_LIMIT -1

#CMD mkdir /.composer_cache
ENV COMPOSER_CACHE_DIR /.composer_cache

RUN apk add --no-cache git unzip

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

#develop layer
RUN apk add --no-cache gnupg
RUN pecl install xdebug
RUN docker-php-ext-enable xdebug
RUN pecl install ast
RUN docker-php-ext-enable ast

# pcntl
RUN docker-php-ext-install pcntl
RUN docker-php-ext-enable pcntl

# php settings
ADD conf.ini /usr/local/etc/php/conf.d/
RUN chmod +r /usr/local/etc/php/conf.d/conf.ini
COPY www.conf /usr/local/etc/php-fpm.d/www.conf

RUN rm -rf /var/cache/apk/* /var/tmp/* /tmp/*

WORKDIR /app
