# Use a PHP-FPM image as the base
FROM php:8.2-fpm

# Install required packages
RUN apt-get update && apt-get install -y \
    build-essential \
    locales \
    libzip-dev \
    zip \
    git \
    unzip \
    curl \
    npm \
    && docker-php-ext-install zip pdo_mysql

# Set working directory
WORKDIR /var/www/html

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY . .


# Install dependencies
RUN composer install

RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod 777 storage/logs/laravel.log

# RUN npm run build

EXPOSE 9000
