FROM composer:2.7 AS composer-build

WORKDIR /www

ADD ./ /www
COPY ./caches/vendor /www/vendor

ENV COMPOSER_ALLOW_SUPERUSER=1

COPY composer.json composer.lock symfony.lock ./
RUN set -eux; \
    composer install --prefer-dist --no-autoloader --no-scripts --no-progress; 

RUN set -eux \
    && mkdir -p var/cache var/log \
    && composer dump-autoload --classmap-authoritative

FROM php:8.2-fpm AS php-build

RUN apt-get update && apt-get install -y \
    libicu-dev \
    && docker-php-ext-install pdo pdo_mysql intl \
    && docker-php-ext-enable intl \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /www
ADD ./ /www

COPY --from=composer-build /www/vendor/ /www/vendor/

RUN mkdir -p var/cache var/log public \
    && chown -R www-data:www-data var/cache var/log public \
    && chmod -R 775 var/cache var/log public

VOLUME ["/www"]