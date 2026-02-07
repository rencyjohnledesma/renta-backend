# Use an official PHP image with Apache
FROM php:8.2-apache

# Install the mysqli extension (needed for your db.php)
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# Enable Apache mod_rewrite (common for APIs)
RUN a2enmod rewrite

# Copy your backend files into the web server directory
COPY . /var/www/html/

# Expose port 80
EXPOSE 80