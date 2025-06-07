FROM php:8.4-fpm

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# Limpiar cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Instalar extensiones PHP
RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Establecer directorio de trabajo
WORKDIR /laravel

# Copiar archivos de dependencias primero (para cache)
COPY composer.json composer.lock ./

# Instalar dependencias SIN scripts
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Copiar el resto del código
COPY . .

# Generar autoload después de copiar todo
RUN composer dump-autoload --optimize

# Permisos para Laravel
RUN chown -R www-data:www-data /laravel \
    && chmod -R 755 /laravel/storage

# Exponer puerto
EXPOSE 9000

# Comando por defecto
CMD ["php-fpm"]