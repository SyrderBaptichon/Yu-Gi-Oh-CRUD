# Dockerfile
FROM php:8.1-fpm-alpine

# Install system dependencies
RUN apk add --no-cache \
    git \
    unzip \
    libzip-dev \
    postgresql-dev \
    icu-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    oniguruma-dev \
    bash \
    nginx \
    supervisor

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
    pdo \
    pdo_pgsql \
    intl \
    zip \
    gd \
    opcache

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/symfony

# Copy composer files first
COPY composer.json composer.lock symfony.lock ./

# Install dependencies (with dev for now, we'll handle env-specific installs differently)
RUN composer install --prefer-dist --no-scripts --no-interaction

# Copy application files
COPY . .

# Set APP_ENV for the build
ARG APP_ENV=prod
ENV APP_ENV=${APP_ENV}

# Run composer scripts and optimize
RUN composer dump-autoload --optimize --classmap-authoritative

# Set permissions
RUN chown -R www-data:www-data /var/www/symfony \
    && chmod -R 755 /var/www/symfony

# Create necessary directories
RUN mkdir -p /var/www/symfony/var/cache \
    && mkdir -p /var/www/symfony/var/log \
    && chown -R www-data:www-data /var/www/symfony/var

EXPOSE 9000

CMD ["php-fpm"]