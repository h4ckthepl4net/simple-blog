FROM webdevops/php-apache-dev:8.2

ENV COMPOSER_ALLOW_SUPERUSER=1

WORKDIR /app

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    && rm -rf /var/lib/apt/lists/*

# Install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy composer files
COPY ./composer.json ./composer.lock /app/

# Install composer dependencies
RUN composer install

# Copy DB migration files
COPY ./migrate_db.php ./database_connection.php /app/

COPY ./vhost.conf /opt/docker/etc/httpd/vhost.conf

# copy apache config
#COPY ./docker/api/dev/vhost.conf /opt/docker/etc/httpd/vhost.conf

EXPOSE 80


