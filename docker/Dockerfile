ARG PHP_VERSION=8.2.12
FROM php:${PHP_VERSION}-fpm-alpine
LABEL maintainer="App Recorrente"

RUN apk update && apk add --no-cache --update \
    $PHPIZE_DEPS \
    libzip-dev \
    g++ \
    gcc \
    curl \
    curl-dev \
    zip \
    unzip \
    moreutils \
    icu-dev \
    freetype \
    freetype-dev \
    libmcrypt-dev \
    imagemagick \
    imagemagick-dev

RUN docker-php-ext-install \
    gd \
    exif \
    opcache \
    pcntl \
    zip \
    intl \
    && php -m \
    && rm -rf /var/lib/apt/lists/* ;

# Installing Mcrypt extension
RUN pecl install -o -f mcrypt && docker-php-ext-enable mcrypt

RUN pecl install imagick && docker-php-ext-enable imagick

# Installing Mongodb extension
RUN pecl install mongodb \
    &&  echo "extension=mongodb.so" > /usr/local/etc/php/conf.d/mongo.ini

#install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN chmod 777 -R /var/www/html/
#copy the laravel.ini witch is the project custom .ini file with some php configs
COPY ./laravel.ini /usr/local/etc/php/conf.d/laravel.ini
