FROM php:8.4-apache

# Instalacja zależności systemowych
# libpq-dev jest niezbędny do skompilowania rozszerzenia pdo_pgsql
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    nodejs \
    npm \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo_pgsql pgsql mbstring exif pcntl bcmath gd zip sockets \
    && rm -rf /var/lib/apt/lists/*

# 4. Włączenie mod_rewrite dla Apache (standard w Laravelu)
RUN a2enmod rewrite

# 5. Kopiowanie plików projektu
COPY . /var/www/html

# 5a. Ustawienie zmiennych środowiskowych dla produkcji
ENV APP_ENV=production
ENV APP_DEBUG=false

# 5a. Instalacja Composera PRZED budowaniem Vite
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --no-interaction --optimize-autoloader

# 5b. Instalacja Node.js dependencies i budowanie Vite assets
RUN npm ci --prefix /var/www/html && npm run build --prefix /var/www/html

# 6. Ustawienie folderu public jako głównego
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# 7. Uprawnienia dla folderów zapisu
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 80

RUN echo "#!/bin/bash\n\
    chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache\n\
    chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache\n\
    \n\
    php artisan migrate --force\n\
    \n\
    # URUCHOMIENIE WORKERA W TLE\n\
    # --queue=csv_imports określa konkretną kolejkę\n\
    # --sleep=3 oszczędza procesor na darmowym planie\n\
    # --tries=3 ponawia próby w razie błędu\n\
    php artisan queue:work --queue=csv_imports --sleep=3 --tries=3 & \n\
    \n\
    apache2-foreground" > /usr/local/bin/start-app.sh && chmod +x /usr/local/bin/start-app.sh

# Ustawiamy nasz skrypt jako punkt startowy
CMD ["/usr/local/bin/start-app.sh"]