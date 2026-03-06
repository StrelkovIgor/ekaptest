# See https://github.com/docker-library/php/blob/master/7.1/fpm/Dockerfile
FROM php:8.4-fpm
ARG TIMEZONE

RUN apt-get update && apt-get install -y \
    openssl \
    git \
    unzip \
	cron \
	nano

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
&& composer --version

# Type docker-php-ext-install to see available extensions
RUN apt-get update \
    && apt-get install -y \
    && docker-php-ext-install mysqli pdo_mysql
	
# Install redis
RUN pecl install -o -f redis \
&&  rm -rf /tmp/pear \
&&  docker-php-ext-enable redis

RUN apt-get update && \
     apt-get install -y \
         libzip-dev \
         && docker-php-ext-install zip
		 
RUN docker-php-ext-install calendar

#intl
RUN apt-get -y update \
&& apt-get install -y libicu-dev \
&& docker-php-ext-configure intl \
&& docker-php-ext-install intl


ENV PHP_MEMORY_LIMIT=2048M
RUN echo 'memory_limit = 2048M' >> /usr/local/etc/php/conf.d/docker-php-memlimit.ini;

WORKDIR /var/www/app/