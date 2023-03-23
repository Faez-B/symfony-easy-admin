# npm run build : not working inside container
# FROM node:19.8.1-alpine as build
# WORKDIR /app
# COPY . .
# # COPY package*.json ./
# RUN npm install --force
# RUN npm run build
# CMD ["node", "index.mjs"]

FROM php:8.2.4-apache AS base

# Modules
RUN apt-get update -y \
    &&  apt-get install -y --no-install-recommends \
        git unzip nodejs npm wget ca-certificates libzip-dev
        # zsh

# PHP Extensions
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN chmod +x /usr/local/bin/install-php-extensions && \
    install-php-extensions gd xdebug intl zip intl pdo pdo_mysql opcache calendar dom mbstring

# Composer
RUN curl -sS https://getcomposer.org/installer | php -- \
    &&  mv composer.phar /usr/local/bin/composer

# Symfony CLI
RUN curl -sS https://get.symfony.com/cli/installer | bash \
    &&  mv /root/.symfony5/bin/symfony /usr/local/bin

# RUN docker-php-ext-install pdo pdo_mysql zip calendar dom mbstring gd xsl;
RUN docker-php-ext-install pdo pdo_mysql zip;

# COPY public/.htaccess /etc/apache2/sites-enabled/000-default.conf

# Oh My Zsh
# Default powerline10k theme, no plugins installed
# RUN sh -c "$(wget -O- https://github.com/deluan/zsh-in-docker/releases/download/v1.1.5/zsh-in-docker.sh)" 

# RUN mkdir -p /home/main/.antigen
# RUN curl -L git.io/antigen > /home/main/.antigen/antigen.zsh

# # Shortcuts
# RUN echo 'alias sc="symfony console"' >> ~/.zshrc \
# && echo 'alias pbc="php bin/console"' >> ~/.zshrc
# # && source ~/.zshrc

# SHELL ["/bin/zsh", "-c"]

# COPY --from=build /app/public/build /var/www/public/build

# COPY --from=npm /var/www/node_modules ./node_modules
# COPY --from=npm /var/www/public/build ./public/build

COPY ./ /var/www/symfonyApp

WORKDIR /var/www/symfonyApp

EXPOSE 8000

# ENV COMPOSER_ALLOW_SUPERUSER=1

RUN npm install --force
RUN composer install
# RUN npm run build





# npm run build : not working inside container
FROM node:19.8.1-alpine as build
COPY --from=base /var/www/symfonyApp /var/www/node
WORKDIR /var/www/node
RUN npm install --force
RUN npm run build




FROM php:8.2.4-apache AS final

RUN apt-get update -y \
    &&  apt-get install -y --no-install-recommends \
        git unzip nodejs npm wget ca-certificates libzip-dev
        # zsh

# PHP Extensions
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN chmod +x /usr/local/bin/install-php-extensions && \
    install-php-extensions gd xdebug intl zip intl pdo pdo_mysql opcache calendar dom mbstring

# Composer
RUN curl -sS https://getcomposer.org/installer | php -- \
    &&  mv composer.phar /usr/local/bin/composer

# Symfony CLI
RUN curl -sS https://get.symfony.com/cli/installer | bash \
    &&  mv /root/.symfony5/bin/symfony /usr/local/bin

RUN docker-php-ext-install pdo pdo_mysql zip;

COPY --from=build /var/www/node /var/www

COPY public/.htaccess /etc/apache2/sites-enabled/000-default.conf

WORKDIR /var/www

EXPOSE 8000

# RUN composer install