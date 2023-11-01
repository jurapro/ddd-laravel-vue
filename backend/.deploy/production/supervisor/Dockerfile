FROM php:8.1-fpm-alpine
ARG USER=www-data
ARG APP_ENV=local
ARG APP_KEY
ARG APP_DEBUG=True
ARG DB_CONNECTION=pgsql
ARG DB_HOST=db
ARG DB_PORT=5432
ARG DB_DATABASE
ARG DB_USERNAME
ARG DB_PASSWORD
ARG QUEUE_CONNECTION=database
ARG BROADCAST_DRIVER=centrifugo
ARG CENTRIFUGO_SECRET
ARG CENTRIFUGO_APIKEY
ARG CENTRIFUGO_HOST

WORKDIR /app

#install packages
RUN apk update && apk add \
    build-base \
    nano \
    bash \
    curl \
    supervisor

# Install extensions
RUN curl -sSLf \
            -o /usr/local/bin/install-php-extensions \
            https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions
RUN chmod +x /usr/local/bin/install-php-extensions
RUN install-php-extensions \
            pdo \
            pdo_pgsql \
            gd

RUN apk add --update --no-cache autoconf g++ imagemagick-dev libtool make pcre-dev \
    && pecl install imagick \
    && docker-php-ext-enable imagick \
    && apk del autoconf g++ libtool make pcre-dev

#install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Add ini-files
COPY --chown=www-data:www-data ./.deploy/production/php.ini /usr/local/etc/php/conf.d/40-custom.ini
#COPY ./.deploy/production/supervisor/supervisor.conf /etc/supervisor/conf.d/laravel-worker.conf
COPY ./.deploy/production/supervisor/supervisor.conf /etc/supervisord.conf


RUN sed -i 's/{{ APP_ENV }}/'$APP_ENV'/g' /etc/supervisord.conf \
    && sed -i 's/{{ APP_KEY }}/'$APP_KEY'/g' /etc/supervisord.conf \
    && sed -i 's/{{ DB_DATABASE }}/'$DB_DATABASE'/g' /etc/supervisord.conf \
    && sed -i 's/{{ APP_DEBUG }}/'$APP_DEBUG'/g' /etc/supervisord.conf \
    && sed -i 's/{{ DB_CONNECTION }}/'$DB_CONNECTION'/g' /etc/supervisord.conf \
    && sed -i 's/{{ DB_HOST }}/'$DB_HOST'/g' /etc/supervisord.conf \
    && sed -i 's/{{ DB_PORT }}/'$DB_PORT'/g' /etc/supervisord.conf \
    && sed -i 's/{{ DB_USERNAME }}/'$DB_USERNAME'/g' /etc/supervisord.conf \
    && sed -i 's/{{ DB_PASSWORD }}/'$DB_PASSWORD'/g' /etc/supervisord.conf \
    && sed -i 's/{{ QUEUE_CONNECTION }}/'$QUEUE_CONNECTION'/g' /etc/supervisord.conf \
    && sed -i 's/{{ BROADCAST_DRIVER }}/'$BROADCAST_DRIVER'/g' /etc/supervisord.conf \
    && sed -i 's/{{ CENTRIFUGO_SECRET }}/'$CENTRIFUGO_SECRET'/g' /etc/supervisord.conf \
    && sed -i 's/{{ CENTRIFUGO_APIKEY }}/'$CENTRIFUGO_APIKEY'/g' /etc/supervisord.conf \
    && sed -i 's/{{ CENTRIFUGO_HOST }}/'$CENTRIFUGO_HOST'/g' /etc/supervisord.conf

# Clean
RUN rm -rf /var/cache/apk/* && docker-php-source delete

# Copy laravel and run composer install
COPY --chown=www-data:www-data laravel /app

ARG COMPOSER_ALLOW_SUPERUSER=1
RUN composer update

RUN php artisan storage:link

# Expose port and start php-fpm server
EXPOSE 9000