FROM php:8.3.4RC1-apache

# Set working directory
WORKDIR /var/www/html

# Copy the application files
COPY src/ .

# Install PDO MySQL PHP extension
RUN docker-php-ext-install pdo_mysql

# Install Node.js
RUN curl -sL https://deb.nodesource.com/setup_14.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g npm

# Install SASS compiler
RUN npm install -g sass

# Expose port 80
EXPOSE 80
