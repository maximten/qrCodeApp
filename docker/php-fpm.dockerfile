FROM php:7.2.10-fpm-alpine3.8

# intl, zip, soap
RUN apk add --update --no-cache libintl icu icu-dev libxml2-dev \
    && docker-php-ext-install intl zip soap

# mysqli, pdo, pdo_mysql, pdo_pgsql
RUN apk add --update --no-cache postgresql-dev \
    && docker-php-ext-install mysqli pdo pdo_mysql

# gd, iconv
RUN apk add --update --no-cache \
        freetype-dev \
        libjpeg-turbo-dev \
        libmcrypt-dev \
        libpng-dev \
    && docker-php-ext-install iconv \
    && docker-php-ext-configure gd \ 
    --with-gd \
    --with-freetype-dir=/usr/include/ \
    --with-png-dir=/usr/include/ \
    --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install gd

# imagick
RUN apk add --update --no-cache php7-imagick

# pdo_pgsql
RUN docker-php-ext-install pdo_pgsql 

# memcached
RUN apk add --update --no-cache autoconf g++ libtool make pcre-dev libmemcached-dev \
&& curl -L -o /tmp/memcached.tar.gz "https://github.com/php-memcached-dev/php-memcached/archive/php7.tar.gz" \
&& mkdir -p memcached \
&& tar -C memcached -zxvf /tmp/memcached.tar.gz --strip 1 \
&& ( \
    cd memcached \
    && phpize \
    && ./configure \
    && make -j$(nproc) \
    && make install \
) \
&& rm -r memcached \
&& rm /tmp/memcached.tar.gz \
&& docker-php-ext-enable memcached \
&& apk del autoconf g++ libtool make pcre-dev

# bash, git
RUN apk add --update --no-cache git bash

# composer
WORKDIR /usr/bin
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
&& php composer-setup.php \
&& php -r "unlink('composer-setup.php');" \
&& mv composer.phar composer
WORKDIR /var/www