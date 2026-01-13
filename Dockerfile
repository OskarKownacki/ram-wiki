# 1. Zmieniamy bazę na PHP 8.3 (wymagane przez spatie/simple-excel)
FROM php:8.3-apache

# 2. Instalacja zależności systemowych (dodano libzip-dev dla rozszerzenia zip)
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl

# 3. Instalacja rozszerzeń PHP (dodano zip oraz sockets)
RUN docker-php-ext-install pdo_pgsql mbstring exif pcntl bcmath gd zip sockets

# 4. Włączenie mod_rewrite dla Apache (standard w Laravelu)
RUN a2enmod rewrite

# 5. Kopiowanie plików projektu
COPY . /var/www/html

# 6. Ustawienie folderu public jako głównego
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# 7. Instalacja Composera
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --no-interaction --optimize-autoloader

# 8. Uprawnienia dla folderów zapisu
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 80

RUN echo "#!/bin/bash\n\
    # Czekamy chwilę na połączenie z bazą i odpalamy migracje\n\
    php artisan migrate --force\n\
    \n\
    # Uruchamiamy Apache w trybie pierwszoplanowym\n\
    apache2-foreground" > /usr/local/bin/start-app.sh && chmod +x /usr/local/bin/start-app.sh

# Ustawiamy nasz skrypt jako punkt startowy
CMD ["/usr/local/bin/start-app.sh"]