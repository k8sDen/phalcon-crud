FROM php:8.2-fpm-buster

ARG PHALCON_VERSION=5.2.1

# Установка зависимостей
RUN apt-get update && apt-get install -y \
    git curl unzip gcc make re2c autoconf libpcre3-dev zlib1g-dev libssl-dev libxml2-dev libonig-dev \
    libsqlite3-dev pkg-config libpng-dev libjpeg-dev libfreetype6-dev \
    && docker-php-ext-install pdo pdo_mysql \
    && rm -rf /var/lib/apt/lists/*

# Сборка и установка Phalcon
RUN set -xe && \
    cd / && \
    docker-php-source extract && \
    curl -sSLO https://github.com/phalcon/cphalcon/archive/v${PHALCON_VERSION}.tar.gz && \
    tar xzf v${PHALCON_VERSION}.tar.gz && \
    docker-php-ext-install -j$(nproc) \
        /cphalcon-${PHALCON_VERSION}/build/phalcon && \
    rm -rf \
        v${PHALCON_VERSION}.tar.gz \
        /cphalcon-${PHALCON_VERSION} && \
    docker-php-source delete

# Установка Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Настройка рабочей директории
WORKDIR /var/www/html
