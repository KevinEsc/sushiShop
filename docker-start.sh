#!/bin/bash
# ─── Script de inicio del contenedor ─────────────────────────────────────────
set -e

echo "=== Generando APP_KEY si no existe ==="
php artisan key:generate --force

echo "=== Creando storage link ==="
php artisan storage:link || true

echo "=== Ejecutando migraciones ==="
php artisan migrate --force

echo "=== Cacheando config y rutas ==="
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "=== Iniciando Apache ==="
apache2-foreground
