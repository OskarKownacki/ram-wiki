FROM php:8.4-apache

# 1. Instalacja zależności (dodany supervisor)
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
    supervisor \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo_pgsql pgsql mbstring exif pcntl bcmath gd zip sockets \
    && rm -rf /var/lib/apt/lists/*

RUN a2enmod rewrite

COPY . /var/www/html

ENV APP_ENV=production
ENV APP_DEBUG=false

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --no-interaction --optimize-autoloader

RUN npm ci --prefix /var/www/html && npm run build --prefix /var/www/html

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# 2. Kopiowanie konfiguracji supervisora
COPY laravel-worker.conf /etc/supervisor/conf.d/laravel-worker.conf

EXPOSE 80

# 3. Aktualizacja skryptu startowego
RUN echo "#!/bin/bash\n\
    chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache\n\
    chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache\n\
    \n\
    php artisan migrate --force\n\
    \n\
    # Uruchomienie supervisora (zarządza Apache i Workerem)\n\
    /usr/bin/supervisord -c /etc/supervisor/conf.d/laravel-worker.conf" > /usr/local/bin/start-app.sh && chmod +x /usr/local/bin/start-app.sh

CMD ["/usr/local/bin/start-app.sh"]