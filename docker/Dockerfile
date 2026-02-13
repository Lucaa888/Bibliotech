FROM php:8.2-apache

# Estensioni PHP utili
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Abilita rewrite (utile se poi vuoi routing)
RUN a2enmod rewrite

# Imposta DocumentRoot su /var/www/html/public
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

# Aggiorna config Apache per usare il DocumentRoot
RUN sed -ri 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/000-default.conf \
    /etc/apache2/apache2.conf \
    /etc/apache2/conf-available/*.conf

# (Opzionale ma consigliato) Imposta timezone
RUN echo "date.timezone=Europe/Rome" > /usr/local/etc/php/conf.d/timezone.ini