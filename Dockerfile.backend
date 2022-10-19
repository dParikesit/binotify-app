FROM php:8.1-apache

RUN apt-get update && apt-get upgrade -y

RUN apt-get install -y libxml2-dev libpq-dev

RUN docker-php-ext-install pgsql pdo pdo_pgsql && docker-php-ext-enable pgsql pdo pdo_pgsql

RUN mkdir -p /app

COPY ./src /var/www/html

RUN  a2enmod rewrite && service apache2 restart

RUN chown -R :www-data /var/www/html/

EXPOSE 80