FROM php:8.3.10

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

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN docker-php-ext-install pdo pdo_pgsql

RUN php -m | grep mbstring

WORKDIR /app

COPY . /app

RUN composer install 

RUN npm install

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]

# Expose the port
EXPOSE 8000
