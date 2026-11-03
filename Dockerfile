FROM php:8.2-fpm-alpine

# Instala dependências do sistema e bibliotecas necessárias
RUN apk add --no-cache \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    nodejs \
    npm \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    oniguruma-dev \
    libxml2-dev

# Configura e instala as extensões PHP essenciais para o Laravel
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip opcache

# Copia o Composer oficial
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copia primeiro os arquivos de dependência para aproveitar o cache do Docker
COPY composer.json composer.lock ./

# Instala as dependências do PHP sem scripts para evitar erros de artisan no build
RUN COMPOSER_MEMORY_LIMIT=-1 composer install --no-dev --optimize-autoloader --no-interaction --no-scripts

# Copia o restante do código da aplicação
COPY . .

# Cria pastas essenciais do Laravel e ajusta permissões
RUN mkdir -p storage/framework/sessions storage/framework/views storage/framework/cache storage/logs bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache

EXPOSE 9000
CMD ["php-fpm"]
