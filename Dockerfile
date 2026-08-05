FROM php:8.3-apache

RUN apt-get update \
    && apt-get install -y --no-install-recommends libonig-dev \
    && rm -rf /var/lib/apt/lists/* \
    && docker-php-ext-install pdo_mysql mbstring \
    && a2enmod rewrite headers expires \
    && sed -ri -e 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/*.conf \
    && sed -ri -e 's!/var/www/!/var/www/html/public!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

WORKDIR /var/www/html
COPY . .
COPY docker/php.ini /usr/local/etc/php/conf.d/shifaflow.ini

RUN chown -R www-data:www-data storage

EXPOSE 80

ENTRYPOINT ["/bin/sh", "/var/www/html/docker/entrypoint.sh"]
CMD ["apache2-foreground"]
