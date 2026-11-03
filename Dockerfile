FROM php:8.2-fpm-alpine

# Instala dependências do sistema e bibliotecas para o GD
RUN apk add --no-cache \
    libzip-dev \
    zip \
    unzip \
    oniguruma-dev \
    git \
    curl \
    nodejs \
    npm \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev

# Configura e instala as extensões PHP
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Instala o Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www

COPY composer.json composer.lock ./
# Substitua a linha do composer por esta:
RUN COMPOSER_MEMORY_LIMIT=-1 composer install --no-dev --optimize-autoloader --no-interaction --verbose

COPY . .

RUN npm ci && npm run build

RUN chown -R www-data:www-data storage bootstrap/cache

CMD ["php-fpm"]
