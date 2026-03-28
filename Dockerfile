FROM php:8.3-apache

# Installer les dépendances système
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libpng-dev \
    libzip-dev \
    unzip \
    git \
    && docker-php-ext-install intl gd zip mysqli pdo_mysql

# Activer le mod_rewrite pour CI4
RUN a2enmod rewrite

# Configuration d'Apache pour pointer vers /public
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Ajouter les permissions pour le nouveau document root
RUN echo "<Directory ${APACHE_DOCUMENT_ROOT}>\n\
    Options Indexes FollowSymLinks\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>" >> /etc/apache2/apache2.conf

# Créer les dossiers nécessaires dans writable et fixer les permissions
RUN mkdir -p writable/cache writable/logs writable/session writable/debugbar \
    && chown -R www-data:www-data writable \
    && chmod -R 775 writable

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

EXPOSE 80
