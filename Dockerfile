FROM php:8.3-apache

LABEL author="sssurii"

ARG NODE_VERSION=20

# Update
RUN apt-get update

RUN apt-get install -y ca-certificates gnupg
RUN mkdir -p /etc/apt/keyrings
RUN curl -fsSL https://deb.nodesource.com/gpgkey/nodesource-repo.gpg.key | gpg --dearmor -o /etc/apt/keyrings/nodesource.gpg
RUN echo "deb [signed-by=/etc/apt/keyrings/nodesource.gpg] https://deb.nodesource.com/node_$NODE_VERSION.x nodistro main" | tee /etc/apt/sources.list.d/nodesource.list

RUN apt-get update

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

#Install dev libs, wget, git etc
RUN apt-get install libpng-dev libicu-dev libpq-dev libzip-dev zip wget git -y

#Install php extensions
RUN docker-php-ext-install pdo_mysql zip exif sockets bcmath

RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql && docker-php-ext-install pdo_pgsql pgsql

#Install php GD extensions and dependency libraries
RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd

RUN docker-php-ext-configure intl \
    && docker-php-ext-install intl

#Enable re-write module
RUN a2enmod rewrite

# Set Apache webroot to "public" folder (for Laravel)
RUN sed -ri -e 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!/var/www/html/public!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

RUN sed -i 's/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

## -------------------------------
##      Setup Apache2 mod_ssl
## -------------------------------

# Prepare fake SSL certificate
RUN apt-get install -y ssl-cert
RUN openssl req -new -newkey rsa:4096 -days 3650 -nodes -x509 -subj  "/C=UK/ST=EN/L=LN/O=FL/CN=127.0.0.1" -keyout ./docker-ssl.key -out ./docker-ssl.pem -outform PEM
RUN mv docker-ssl.pem /etc/ssl/certs/ssl-cert-snakeoil.pem
RUN mv docker-ssl.key /etc/ssl/private/ssl-cert-snakeoil.key

# Enable the mod and default ssl site
RUN a2enmod ssl
RUN a2ensite default-ssl.conf

## ---------------------------------------
##      Install Node
## ---------------------------------------

RUN apt-get install nodejs -y
RUN npm install -g npm
