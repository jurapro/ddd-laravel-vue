FROM php:8.1-fpm-alpine
ARG USER=www-data

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

# Clean
RUN rm -rf /var/cache/apk/* && docker-php-source delete

# Copy laravel and run composer install
COPY --chown=www-data:www-data laravel /app

ARG COMPOSER_ALLOW_SUPERUSER=1
RUN composer update

RUN php artisan storage:link

# Expose port and start php-fpm server
EXPOSE 9000