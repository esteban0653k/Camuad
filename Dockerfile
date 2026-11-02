FROM php:8.3-cli

# Instalar dependencias del sistema esenciales
RUN apt-get update && apt-get install -y --no-install-recommends \
    git \
    unzip \
    libzip-dev \
    && docker-php-ext-install pdo_mysql zip \
    && rm -rf /var/lib/apt/lists/*

# Instalar Composer oficial
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Definir el directorio de trabajo
WORKDIR /var/www/html

# Exponer el puerto para el servidor de desarrollo de Laravel
EXPOSE 8000

# Comando por defecto para iniciar el servidor interno de Laravel
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]