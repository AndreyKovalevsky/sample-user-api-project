FROM php:8.0-fpm

RUN apt-get update && apt-get install -y libpq-dev
RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql
RUN docker-php-ext-install pdo pdo_pgsql

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN apt-get install -y libzip-dev
RUN docker-php-ext-install zip

RUN usermod -u 1000 www-data \
    && chown -R www-data:www-data /var/www
