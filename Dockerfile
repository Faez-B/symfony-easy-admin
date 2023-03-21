FROM php:8.1.17

WORKDIR /app

# Modules
RUN apt-get update \
    &&  apt-get install -y \
        git unzip nodejs npm wget ca-certificates 
        # zsh

# PHP Extensions
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN chmod +x /usr/local/bin/install-php-extensions && \
    install-php-extensions gd xdebug intl zip

# Composer
RUN curl -sS https://getcomposer.org/installer | php -- \
    &&  mv composer.phar /usr/local/bin/composer

# Symfony CLI
RUN curl -sS https://get.symfony.com/cli/installer | bash \
    &&  mv /root/.symfony5/bin/symfony /usr/local/bin

COPY . /app/

RUN composer install
RUN npm install

# 
# RUN docker-php-ext-configure intl \
#     &&  docker-php-ext-install pdo pdo_mysql zip calendar dom mbstring gd xsl

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

# COPY ./ /app