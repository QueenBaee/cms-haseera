# syntax=docker/dockerfile:1

# =========================================================
# FRONTEND BUILD
# =========================================================

FROM node:22-alpine AS frontend

WORKDIR /app

COPY package.json package-lock.json ./

RUN npm ci

COPY . .

RUN npm run build


# =========================================================
# PHP / LARAVEL / FRANKENPHP
# =========================================================

FROM dunglas/frankenphp:1-php8.4-bookworm AS app

WORKDIR /app

# Nginx host akan handle HTTPS.
# FrankenPHP hanya listen HTTP internal container.
ENV SERVER_NAME=:8080
ENV SERVER_ROOT=public/

# PHP production configuration
RUN cp "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
COPY php-uploads.ini "$PHP_INI_DIR/conf.d/zz-uploads.ini"

# Tools yang dibutuhkan Composer / healthcheck
RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        git \
        unzip \
        curl \
    && rm -rf /var/lib/apt/lists/*

# PHP extensions
RUN install-php-extensions \
    pdo_mysql \
    mbstring \
    bcmath \
    intl \
    zip \
    gd \
    exif \
    pcntl \
    opcache

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# =========================================================
# COMPOSER DEPENDENCIES
# =========================================================

COPY composer.json composer.lock ./

RUN composer install \
    --no-dev \
    --no-interaction \
    --prefer-dist \
    --no-progress \
    --no-scripts \
    --no-autoloader

# =========================================================
# APPLICATION
# =========================================================

COPY . .

# Copy hasil build Vite
COPY --from=frontend /app/public/build /app/public/build

# Install Composer final + optimized autoloader
RUN composer install \
    --no-dev \
    --no-interaction \
    --prefer-dist \
    --no-progress \
    --optimize-autoloader

# =========================================================
# LARAVEL DIRECTORIES
# =========================================================

RUN mkdir -p \
        storage/app/public \
        storage/framework/cache \
        storage/framework/sessions \
        storage/framework/views \
        storage/logs \
        bootstrap/cache

# Pastikan storage symlink menggunakan path di DALAM container.
# Jangan sampai membawa symlink host /home/nmc/... ke image.
RUN rm -rf public/storage \
    && ln -s /app/storage/app/public /app/public/storage

# FrankenPHP akan dijalankan sebagai www-data
RUN chown -R www-data:www-data \
        /app/storage \
        /app/bootstrap/cache \
        /data \
        /config

USER www-data

EXPOSE 8080

# =========================================================
# HEALTHCHECK
# =========================================================

HEALTHCHECK \
    --interval=30s \
    --timeout=5s \
    --start-period=40s \
    --retries=3 \
    CMD curl --fail --silent http://127.0.0.1:8080/ >/dev/null || exit 1

# =========================================================
# STARTUP
# =========================================================

CMD ["sh", "-c", "set -e; \
    echo '========================================'; \
    echo ' HASEERA CONTAINER STARTING'; \
    echo '========================================'; \
    echo '==> Running database migrations...'; \
    php artisan migrate --force; \
    echo '==> Clearing Laravel caches...'; \
    php artisan optimize:clear; \
    echo '==> Building Laravel production caches...'; \
    php artisan optimize; \
    echo '==> Starting FrankenPHP...'; \
    exec frankenphp run --config /etc/frankenphp/Caddyfile"]
