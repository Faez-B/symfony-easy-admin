FROM php:8.2.4-apache AS base
COPY ./ /var/www/symfonyApp

RUN apt-get update -y \
    &&  apt-get install -y --no-install-recommends \
        git

# Composer
RUN curl -sS https://getcomposer.org/installer | php -- \
    &&  mv composer.phar /usr/local/bin/composer

WORKDIR /var/www/symfonyApp
RUN composer install


# npm run build : not working inside php container
FROM node:19.8.1-alpine as build
COPY --from=base /var/www/symfonyApp /var/www/node
COPY --from=base /usr/local/bin/composer /usr/local/bin/composer
WORKDIR /var/www/node
RUN npm install --force
RUN npm run build


FROM php:8.2.4-apache AS final

RUN apt-get update -y \
    &&  apt-get install -y --no-install-recommends \
        git ca-certificates libzip-dev

# PHP Extensions
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod +x /usr/local/bin/install-php-extensions && \
    install-php-extensions gd xdebug intl zip intl pdo pdo_mysql opcache calendar dom mbstring

# Symfony CLI
RUN curl -sS https://get.symfony.com/cli/installer | bash \
    &&  mv /root/.symfony5/bin/symfony /usr/local/bin

RUN docker-php-ext-install pdo pdo_mysql zip;

COPY --from=build /var/www/node /var/www
COPY --from=build /usr/local/bin/composer /usr/local/bin/composer

COPY public/.htaccess /etc/apache2/sites-enabled/000-default.conf

WORKDIR /var/www

EXPOSE 8000