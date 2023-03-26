# Composer install
FROM php:8.2.4-apache AS base
RUN apt-get update -y \
    &&  apt-get install -y --no-install-recommends \
        git libzip-dev zip unzip
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
WORKDIR /var/www/symfonyApp
COPY ./ ./
RUN composer install


# NPM install
# npm run build : not working inside php container
FROM node:19.8.1-alpine as build
COPY --from=base /var/www/symfonyApp /var/www/node
WORKDIR /var/www/node
RUN npm install --force
RUN npm run build


# Final image
FROM php:8.2.4-apache AS final

RUN apt-get update -y \
    &&  apt-get install -y --no-install-recommends \
        git ca-certificates libzip-dev

# PHP Extensions
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod +x /usr/local/bin/install-php-extensions && \
    install-php-extensions gd xdebug apcu opcache intl zip pdo pdo_mysql

# Symfony CLI
RUN curl -sS https://get.symfony.com/cli/installer | bash \
    &&  mv /root/.symfony5/bin/symfony /usr/local/bin

# RUN docker-php-ext-install pdo pdo_mysql zip;

COPY --from=build /var/www/node /var/www
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

COPY public/.htaccess /etc/apache2/sites-enabled/000-default.conf

WORKDIR /var/www

# Permissions
RUN chmod -R 777 ./public/uploads

# Tables creation
# 1 -
# RUN symfony console doctrine:schema:update --force --complete
# 2 -
# RUN php bin/console make:migration
# RUN php bin/console doctrine:migrations:migrate --no-interaction 

EXPOSE 8000