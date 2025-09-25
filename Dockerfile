FROM php:8.1-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install MySQL extension
RUN docker-php-ext-install mysqli

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy application files
COPY . /var/www/html/

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Set proper permissions
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 755 /var/www/html

# Create upload directories with proper permissions
RUN mkdir -p /var/www/html/uploads/consoles /var/www/html/uploads/genres /var/www/html/uploads/portraits /var/www/html/uploads/videogames
RUN chown -R www-data:www-data /var/www/html/uploads
RUN chmod -R 755 /var/www/html/uploads

# Expose port 80
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]
