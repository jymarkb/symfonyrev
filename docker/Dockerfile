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

RUN docker-php-ext-install pdo pdo_mysql

WORKDIR /www
ADD ./ /www

COPY --from=composer-build /www/vendor/ /www/vendor/

RUN mkdir -p /www/var/cache /www/var/logs && \
    chown -R www-data:www-data /www && \
    chmod -R 755 /www/var/cache /www/var/logs

VOLUME ["/www"]