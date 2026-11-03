FROM php:8.2-fpm-alpine

RUN apk add --no-cache \
    libzip-dev \
    zip \
    unzip \
    oniguruma-dev \
    git \
    curl \
    nodejs \
    npm

RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www

COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-interaction

COPY . .

RUN npm ci && npm run build

RUN chown -R www-data:www-data storage bootstrap/cache

CMD ["php-fpm"]
