FROM php:8.3.21

# Install system dependencies
RUN apt-get update && apt-get install -y \
    openssl \
    zip \
    unzip \
    git \
    libpq-dev \
    nodejs \
    npm \
    --no-install-recommends && rm -rf /var/lib/apt/lists/*

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql

# Cek modul PHP (opsional)
RUN php -m | grep mbstring

# Set workdir
WORKDIR /app

# Copy project files
COPY . /app

# Install PHP dependencies
RUN composer install \
    && composer require endroid/qr-code

# Install Node.js dependencies
RUN npm install

# Laravel: Buat symbolic link untuk storage
RUN php artisan storage:link || true

# Expose Laravel port
EXPOSE 8000

# Jalankan Laravel dev server
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
