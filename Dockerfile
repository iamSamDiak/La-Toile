FROM php:8.2.7-apache

WORKDIR /app

COPY . /app

RUN mv composer.phar /usr/local/bin/composer

RUN curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.deb.sh' | bash

RUN apt install symfony-cli -y \
    && curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add - \
    && echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list \
    && apt-get update \
    && apt install yarn -y \
    && export COMPOSER_ALLOW_SUPERUSER=1 \
    && composer install \
    && yarn install \
    && yarn encore dev

EXPOSE 8000

CMD ["symfony", "serve"]