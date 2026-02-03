FROM php:8.3-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    curl \
    && docker-php-ext-install \
        pdo_mysql \
        mbstring \
        zip \
        exif \
        pcntl \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy application files
COPY . .

# Install PHP dependencies ONLY (no artisan here)
RUN composer install --no-dev --optimize-autoloader

# Laravel permissions
RUN chown -R www-data:www-data storage bootstrap/cache \
 && chmod -R 775 storage bootstrap/cache

# Expose Render port
EXPOSE 10000

# Run at container startup (runtime, envs available)
CMD php artisan config:clear \
 && php artisan cache:clear \
 && php artisan migrate --force \
 && php -S 0.0.0.0:10000 -t public
