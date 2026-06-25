# Meu PHP é 8.5, e as dependencias são do php 8.3, então usei o docker

FROM php:8.3-cli-alpine

RUN apk add --no-cache \
    bash \
    git \
    unzip \
    libzip-dev \
    && docker-php-ext-install zip pdo pdo_mysql

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]