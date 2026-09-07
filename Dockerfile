FROM php:8.2-apache

# Installer les dependances PostgreSQL
RUN apt-get update && \
    apt-get install -y libpq-dev && \
    docker-php-ext-install pdo pdo_pgsql && \
    apt-get clean && rm -rf /var/lib/apt/lists/*

# Activer mod_rewrite pour les URLs propres
RUN a2enmod rewrite

# Configurer Apache pour utiliser le port de Render
RUN sed -i 's/80/${PORT}/g' /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf

# Copier les fichiers du projet
COPY . /var/www/html/

# Donner les bons droits
RUN chown -R www-data:www-data /var/www/html

# Exposer le port (Render utilise la variable PORT)
EXPOSE ${PORT}

# Demarrer Apache
CMD ["apache2-foreground"]
