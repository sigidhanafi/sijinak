FROM php:8.3.21

# Install system dependencies termasuk ImageMagick
RUN apt-get update && apt-get install -y \
    openssl \
    zip \
    unzip \
    git \
    libpq-dev \
    nodejs \
    npm \
    libmagickwand-dev --no-install-recommends && rm -rf /var/lib/apt/lists/*

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql

# Install Imagick extension
RUN pecl install imagick && docker-php-ext-enable imagick

WORKDIR /app

# Copy project files
COPY . /app

# Install dependencies
RUN composer install
RUN npm install

# Run Laravel-specific setup: storage link
RUN php artisan storage:link || true

# Expose port for Laravel server
EXPOSE 8000

# Start Laravel server
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
