FROM php:8.2-apache

RUN a2enmod rewrite headers

# PDO MySQL
RUN docker-php-ext-install pdo pdo_mysql

WORKDIR /app

# Apache vhost
COPY docker/php/vhost.conf /etc/apache2/sites-available/000-default.conf

# Permissions for storage
RUN mkdir -p /app/storage/logs /app/storage/uploads     && chown -R www-data:www-data /app/storage
