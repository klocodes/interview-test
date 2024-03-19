ARG PHP_VERSION

FROM php:${PHP_VERSION}-fpm-alpine

ARG PHP_ENABLE_XDEBUG='off'
ARG TZ='UTC'

# https://wiki.alpinelinux.org/wiki/Setting_the_timezone
RUN echo "${TZ}" && apk --update add tzdata && \
    cp /usr/share/zoneinfo/$TZ /etc/localtime && \
    echo $TZ > /etc/timezone && \
    apk del tzdata

RUN apk add --no-cache bash msmtp perl wget procps shadow libzip icu \
    libintl patch acl git gettext-dev libcurl libxml2-dev openssh-client pcre-dev su-exec build-base oniguruma-dev \
    imagemagick imagemagick-dev  \
    gmp-dev gettext gettext-dev postgresql-dev

RUN apk add --update --no-cache --virtual build-essentials \
    icu-dev icu-libs zlib-dev g++ gcc make automake autoconf libzip-dev \
    htop && \
    docker-php-ext-configure gettext && \
    docker-php-ext-configure opcache --enable-opcache && \
    docker-php-ext-configure pcntl --enable-pcntl && \
    docker-php-ext-configure soap && \
    docker-php-ext-configure intl && \
    docker-php-ext-install intl && \
    docker-php-ext-install gettext && \
    docker-php-ext-install pcntl && \
    docker-php-ext-install opcache && \
    docker-php-ext-install soap && \
    docker-php-ext-install xml && \
    docker-php-ext-install gmp && \
    docker-php-ext-install opcache && \
    docker-php-ext-install exif && \
    docker-php-ext-install zip && \
    docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql && \
    docker-php-ext-install pdo pdo_pgsql pgsql && \
    pecl install redis && \
    docker-php-ext-enable redis && \
    pecl install imagick && \
    docker-php-ext-enable imagick && \
    apk del build-essentials && rm -rf /usr/app/php*

RUN apk add --no-cache $PHPIZE_DEPS

# Enable Xdebug
RUN if [ "${PHP_ENABLE_XDEBUG}" == "on" ]; then \
      yes | pecl install xdebug && \
      echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini && \
      echo "xdebug.remote_enable=on" >> /usr/local/etc/php/conf.d/xdebug.ini && \
      echo "xdebug.remote_autostart=off" >> /usr/local/etc/php/conf.d/xdebug.ini && \
      php -m; \
    else \
      echo "Skip xdebug support"; \
    fi

# Clean
RUN rm -rf /var/cache/apk/* && docker-php-source delete

USER root

RUN curl -sS https://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer
RUN /usr/local/bin/composer self-update

USER www-data:www-data

WORKDIR /var/www/