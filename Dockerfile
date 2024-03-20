FROM php:8.3.4RC1-apache

# Set working directory
WORKDIR /var/www/html

# Copy the application files
COPY src/ .

# Install PDO MySQL PHP extension
RUN docker-php-ext-install pdo_mysql

# Expose port 80
EXPOSE 80
