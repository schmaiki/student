# Dockerfile
FROM php:8.2-apache
USER root
# Install PHP extensions and composer and symfony cli
RUN apt-get update && apt-get install nano wget libpq-dev zlib1g-dev libicu-dev g++ git unzip libzip-dev mariadb-client -y
RUN docker-php-ext-install pdo_mysql zip intl
RUN pecl install apcu
RUN docker-php-ext-enable apcu
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN wget https://get.symfony.com/cli/installer -O - | bash;
RUN mv /root/.symfony5/bin/symfony /usr/local/bin/symfony;
RUN rm -rf /root/.symfony5

ENV DOCKERIZE_VERSION v0.6.1
RUN curl -OL https://github.com/jwilder/dockerize/releases/download/$DOCKERIZE_VERSION/dockerize-alpine-linux-amd64-$DOCKERIZE_VERSION.tar.gz \
    && tar -C /usr/local/bin -xzvf dockerize-alpine-linux-amd64-$DOCKERIZE_VERSION.tar.gz \
    && rm dockerize-alpine-linux-amd64-$DOCKERIZE_VERSION.tar.gz


# Update the document root
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

# Update the default apache site config
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Copy the custom apache config
COPY ./docker/apache/apache-config.conf /etc/apache2/sites-available/000-default.conf

RUN a2enmod rewrite
RUN a2enmod headers
WORKDIR /var/www/html

COPY . .

RUN chown -R www-data:www-data /var/www/html/public
RUN composer install --no-interaction

CMD ["apache2-foreground"]