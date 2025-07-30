# Use official PHP with Apache image
FROM php:8.2-apache

# Install MongoDB extension
RUN apt-get update && \
    apt-get install -y libssl-dev && \
    pecl install mongodb && \
    docker-php-ext-enable mongodb

# Enable Apache rewrite module (optional, but good for clean URLs)
RUN a2enmod rewrite

# Copy all project files into the container
COPY . /var/www/html/

# Set working directory
WORKDIR /var/www/html

# Set proper permissions (optional)
RUN chown -R www-data:www-data /var/www/html
