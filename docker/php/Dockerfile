FROM php:7.4-fpm

RUN apt-get update && apt-get install -y wget git unzip \
	&& pecl install xdebug-2.9.1 \
	&& docker-php-ext-enable xdebug

#RUN curl -XGET https://getcomposer.org/download/latest-stable/composer.phar > /bin/composer && chmod +x /bin/composer
