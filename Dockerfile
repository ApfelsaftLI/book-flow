FROM php:8.3.4RC1-apache

# Set working directory
WORKDIR /var/www/html

# Copy the application files
COPY src/ .

# Install PDO MySQL PHP extension
RUN docker-php-ext-install pdo_mysql

# Install Node.js
RUN apt-get update && apt-get install -y ca-certificates curl gnupg \
  && curl -fsSL https://deb.nodesource.com/gpgkey/nodesource-repo.gpg.key | gpg --dearmor -o /etc/apt/keyrings/nodesource.gpg \
  && NODE_MAJOR=20 \
  && echo "deb [signed-by=/etc/apt/keyrings/nodesource.gpg] https://deb.nodesource.com/node_$NODE_MAJOR.x nodistro main" | tee /etc/apt/sources.list.d/nodesource.list \
  && apt-get update && apt-get install nodejs -y


# Install SASS compiler
RUN npm install -g sass

# CMD ["sass", "--watch", "assets/styles/sass:assets/styles"]

# Expose port 80
EXPOSE 80
