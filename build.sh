#!/usr/bin/env bash
# ─── Build script para Render (PHP + PostgreSQL/Supabase) ────────────────────
set -e

echo "=== [1/5] Instalando dependencias PHP ==="
composer install --no-dev --optimize-autoloader --no-interaction

echo "=== [2/5] Instalando dependencias Node.js ==="
npm ci

echo "=== [3/5] Compilando assets con Vite ==="
npm run build

echo "=== [4/5] Configurando caché de Laravel ==="
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "=== [5/5] Ejecutando migraciones ==="
php artisan migrate --force

echo "=== Storage link ==="
php artisan storage:link || true

echo "✅ Build completado."
