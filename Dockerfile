# Dockerfile

# Gunakan image resmi Apache
FROM php:7.4-apache

RUN docker-php-ext-install mysqli && a2enmod rewrite

# Copy konfigurasi Apache Anda ke dalam container
COPY 000-default.conf /etc/apache2/sites-available/000-default.conf

# Copy proyek PHP (atau proyek statis) ke dalam web root Apache
COPY . /var/www/html

RUN a2enmod

# RUN chmod -R 755 /usr/local/apache2/htdocs/
RUN chmod -R 755 /var/www/html

EXPOSE 80
