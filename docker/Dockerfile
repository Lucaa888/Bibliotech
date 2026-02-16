FROM php:8.2-apache


RUN docker-php-ext-install pdo pdo_mysql mysqli

RUN a2enmod rewrite


ENV APACHE_DOCUMENT_ROOT=/var/www/html/public


RUN sed -ri 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/000-default.conf \
    /etc/apache2/apache2.conf \
    /etc/apache2/conf-available/*.conf


RUN echo "date.timezone=Europe/Rome" > /usr/local/etc/php/conf.d/timezone.ini