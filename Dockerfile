FROM php:8.2-apache

# Installe les dépendances nécessaires à pdo_pgsql
RUN apt-get update && \
    apt-get install -y libpq-dev && \
    docker-php-ext-install pdo pdo_pgsql

# Copie tous les fichiers dans le dossier web d’Apache
COPY . /var/www/html/

# Donne les bons droits
RUN chown -R www-data:www-data /var/www/html
