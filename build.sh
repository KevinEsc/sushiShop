#!/usr/bin/env bash
# ─── Build script para Render ────────────────────────────────────────────────
# Este script se ejecuta automáticamente cada vez que Render hace un deploy.

set -e  # Detener si algún comando falla

echo "=== [1/5] Instalando dependencias PHP (Composer) ==="
composer install --no-dev --optimize-autoloader --no-interaction

echo "=== [2/5] Instalando dependencias Node.js ==="
npm ci

echo "=== [3/5] Compilando assets con Vite ==="
npm run build

echo "=== [4/5] Configurando Laravel para producción ==="
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "=== [5/5] Ejecutando migraciones ==="
php artisan migrate --force

echo "=== [OPCIONAL] Creando storage link ==="
php artisan storage:link || true

echo ""
echo "✅ Build completado exitosamente."
