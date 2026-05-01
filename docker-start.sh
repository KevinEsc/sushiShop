#!/bin/bash
# ─── Script de inicio del contenedor ─────────────────────────────────────────
set -e

# Copiar .env desde Render Secret Files si existe
if [ -f "/etc/secrets/.env" ]; then
    echo "=== Copiando .env desde Secret Files ==="
    cp /etc/secrets/.env /var/www/html/.env
fi

echo "=== Generando APP_KEY si no existe ==="
php artisan key:generate --force

echo "=== Creando storage link ==="
php artisan storage:link || true

echo "=== Ejecutando migraciones ==="
php artisan migrate --force

echo "=== Cacheando configuración ==="
php artisan config:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "=== Iniciando Apache ==="
apache2-foreground
