FROM webdevops/php-apache-dev:8.2

WORKDIR /app

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    && rm -rf /var/lib/apt/lists/*

# Install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install composer dependencies
RUN composer install

# run migrations and seeders
./vendor/bin/doctrine-migrations migrations:migrate --no-interaction

# copy apache config
#COPY ./docker/api/dev/vhost.conf /opt/docker/etc/httpd/vhost.conf

EXPOSE 80

CMD ["apache2ctl", "-D", "FOREGROUND"]


