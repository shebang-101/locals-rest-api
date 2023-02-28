FROM php:8.1-fpm

# Kkeyboard layout auto config needed for build in Ubuntu
# Installation of PHP extensions
RUN apt-get update \
    && DEBIAN_FRONTEND=noninteractive apt-get install -y keyboard-configuration build-essential xorg libssl-dev libxrender-dev wget gdebi git mariadb-client \
    && apt-get install -y zlib1g-dev libzip-dev libpng-dev libjpeg-dev libicu-dev libfreetype6-dev g++ \
    && docker-php-ext-install pdo_mysql \
    && pecl install apcu \
    && docker-php-ext-enable apcu \
    && echo "apc.enabled=1" >> /usr/local/etc/php/conf.d/apcu.ini \
    && echo "apc.enable_cli=1" >> /usr/local/etc/php/conf.d/apcu.ini \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl \
    && docker-php-ext-install zip \
    && docker-php-ext-configure gd \
    && docker-php-ext-install gd

# Composer installation
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --filename=composer \
    && php -r "unlink('composer-setup.php');" \
    && mv composer /usr/local/bin/composer

WORKDIR /usr/src/app

RUN PATH=$PATH:/usr/src/apps/vendor/bin:bin