FROM php:8.2.7RC1-zts-alpine3.18

WORKDIR /app

COPY . /app

RUN mv composer.phar /usr/local/bin/composer

RUN apk add --no-cache bash \
    && curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.alpine.sh' | bash \
    && apk add symfony-cli

RUN apk add yarn \
    && export COMPOSER_ALLOW_SUPERUSER=1 \
    && composer install \
    && yarn install \
    && yarn encore dev

EXPOSE 80

CMD ["symfony", "serve"]