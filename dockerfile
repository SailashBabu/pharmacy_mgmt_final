FROM php:8.2-apache

# Install MongoDB extension
RUN apt-get update && \
    apt-get install -y libssl-dev && \
    pecl install mongodb && \
    docker-php-ext-enable mongodb

# Enable mod_rewrite if needed
RUN a2enmod rewrite

# Copy your app into the container
COPY . /var/www/html/

# Set working directory
WORKDIR /var/www/html
