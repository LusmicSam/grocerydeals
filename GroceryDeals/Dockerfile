FROM php:8.2-fpm-alpine

# Install system deps
RUN apk add --no-cache \
    nginx \
    supervisor \
    curl \
    git \
    zip \
    unzip \
    nodejs \
    npm \
    openssl-dev

# Install PHP extensions
RUN apk add --no-cache --virtual .build-deps $PHPIZE_DEPS autoconf g++ make \
    && pecl install mongodb \
    && docker-php-ext-enable mongodb \
    && docker-php-ext-install pdo pdo_mysql opcache \
    && apk del .build-deps

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy composer files first (layer cache)
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist

# Copy app source
COPY . .

# Build assets and optimise
RUN npm ci && npm run build \
    && composer dump-autoload --optimize \
    && php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache

# Permissions
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Nginx config
COPY docker/nginx.conf /etc/nginx/http.d/default.conf

# Supervisor config
COPY docker/supervisord.conf /etc/supervisord.conf

EXPOSE 80

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]
