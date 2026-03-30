FROM php:8.3-apache

# Installer les dépendances système (intl, gd, zip, mysqli, pdo_mysql)
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libpng-dev \
    libzip-dev \
    unzip \
    && docker-php-ext-install intl gd zip mysqli pdo_mysql

# Activer les modules Apache
RUN a2enmod rewrite headers

# Configuration d'Apache pour pointer vers la RACINE /var/www/html
ENV APACHE_DOCUMENT_ROOT /var/www/html
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

RUN mkdir -p public/uploads/articles \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 777 /var/www/html

COPY init.sh /init.sh
RUN chmod +x /init.sh

WORKDIR /var/www/html

EXPOSE 80

# Utiliser le script d'initialisation pour le seeder auto
ENTRYPOINT ["/init.sh"]
