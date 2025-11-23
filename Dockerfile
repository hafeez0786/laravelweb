# 1. Use official PHP image with required extensions
FROM php:8.0-fpm

# 2. Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libpq-dev \
    libonig-dev \
    libzip-dev
    && docker-php-ext-install pdo_mysql bcmath
# 3. Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql pdo_pgsql mbstring zip

# 4. Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# 5. Set working directory
WORKDIR /var/www

# 6. Copy project files
COPY . .

# 7. Install dependencies
RUN composer install --optimize-autoloader --no-dev

# 8. Expose port
EXPOSE 8000

# 9. Start Laravel app
CMD php artisan serve --host=0.0.0.0 --port=8000
