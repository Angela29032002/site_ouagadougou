FROM php:8.2-apache

# Activer PDO PostgreSQL
RUN docker-php-ext-install pdo pdo_pgsql

# Copier ton site dans le dossier public d’Apache
COPY ./public /var/www/html/
COPY ./includes /var/www/html/includes
COPY ./css /var/www/html/css
COPY ./js /var/www/html/js
COPY ./images /var/www/html/images
