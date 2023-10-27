FROM php:8.1.8-fpm
ARG USER=www-data
ARG APP_KEY
ARG DB_DATABASE
ARG DB_USERNAME
ARG DB_PASSWORD
ARG CENTRIFUGO_SECRET
ARG CENTRIFUGO_APIKEY

RUN useradd -m -s /bin/bash -p $(openssl passwd -1 $USER) $USER
RUN usermod -g $USER $USER
RUN usermod -aG sudo $USER

WORKDIR /app

RUN apt-get update && \
    apt-get install -y --no-install-recommends \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libpq-dev \
    libzip-dev && \
    apt-get install -y \
    supervisor && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/*

RUN chown -R $USER:$USER .

RUN docker-php-ext-install pdo pdo_pgsql sockets bcmath zip pcntl posix
COPY --chown=$USER:$USER . .
RUN chmod +x ./laravel/wait-for-it.sh
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY ./.deploy/develop/php.ini /usr/local/etc/php/conf.d/40-custom.ini
COPY ./.deploy/develop/supervisor/supervisor.conf /etc/supervisor/conf.d/laravel-worker.conf

RUN sed -i 's/{{ APP_KEY }}/'$APP_KEY'/g' /etc/supervisor/conf.d/laravel-worker.conf \
    && sed -i 's/{{ DB_DATABASE }}/'$DB_DATABASE'/g' /etc/supervisor/conf.d/laravel-worker.conf \
    && sed -i 's/{{ DB_USERNAME }}/'$DB_USERNAME'/g' /etc/supervisor/conf.d/laravel-worker.conf \
    && sed -i 's/{{ DB_PASSWORD }}/'$DB_PASSWORD'/g' /etc/supervisor/conf.d/laravel-worker.conf \
    && sed -i 's/{{ CENTRIFUGO_SECRET }}/'$CENTRIFUGO_SECRET'/g' /etc/supervisor/conf.d/laravel-worker.conf \
    && sed -i 's/{{ CENTRIFUGO_APIKEY }}/'$CENTRIFUGO_APIKEY'/g' /etc/supervisor/conf.d/laravel-worker.conf \
    && sed -i 's/{{ USER }}/'$USER'/g' /etc/supervisor/conf.d/laravel-worker.conf


RUN composer install --working-dir=./laravel
RUN chown -R $USER:$USER .
USER $USER
