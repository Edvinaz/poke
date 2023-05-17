FROM php:8.2-apache

RUN docker-php-ext-install mysqli pdo pdo_mysql
RUN apt-get update && apt-get install -y zlib1g-dev libzip-dev unzip

# Copy the php.ini file
COPY php/php.ini /usr/local/etc/php/php.ini

# Install Composer
COPY composer.* ./
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set the working directory
WORKDIR /var/www/html

# Install project dependencies
RUN composer install --no-scripts --no-autoloader --no-interaction

# Copy the rest of the application
COPY . .

# Generate the autoloader
RUN composer dump-autoload --optimize --no-dev --classmap-authoritative

# Set the proper file permissions
RUN chown -R www-data:www-data /var/www/html
