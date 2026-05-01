#!/bin/bash
# ─── Script de inicio del contenedor ─────────────────────────────────────────
set -e

echo "=== Verificando .env ==="

# Opción A: Copiar desde Render Secret Files
if [ -f "/etc/secrets/.env" ]; then
    echo "--- Copiando desde Secret Files ---"
    cp /etc/secrets/.env /var/www/html/.env
    chmod 644 /var/www/html/.env

# Opción B: Construir .env desde variables de entorno del sistema
elif [ ! -f "/var/www/html/.env" ]; then
    echo "--- Construyendo .env desde variables de entorno ---"
    cat > /var/www/html/.env <<EOF
APP_NAME="${APP_NAME:-MoniWis Sushi}"
APP_ENV=${APP_ENV:-production}
APP_KEY=${APP_KEY}
APP_DEBUG=${APP_DEBUG:-false}
APP_URL=${APP_URL:-http://localhost}

LOG_CHANNEL=${LOG_CHANNEL:-stderr}
LOG_LEVEL=${LOG_LEVEL:-error}

DB_CONNECTION=${DB_CONNECTION:-pgsql}
DB_HOST=${DB_HOST}
DB_PORT=${DB_PORT:-5432}
DB_DATABASE=${DB_DATABASE:-postgres}
DB_USERNAME=${DB_USERNAME:-postgres}
DB_PASSWORD=${DB_PASSWORD}
DB_SSLMODE=${DB_SSLMODE:-require}

SESSION_DRIVER=${SESSION_DRIVER:-database}
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null

BROADCAST_CONNECTION=log
FILESYSTEM_DISK=local
QUEUE_CONNECTION=${QUEUE_CONNECTION:-database}
CACHE_STORE=${CACHE_STORE:-database}

WHATSAPP_NUMBER=${WHATSAPP_NUMBER}

MAIL_MAILER=log
MAIL_FROM_ADDRESS="${MAIL_FROM_ADDRESS:-contacto@moniwissushi.cl}"
MAIL_FROM_NAME="${APP_NAME:-MoniWis Sushi}"

VITE_APP_NAME="${APP_NAME:-MoniWis Sushi}"
EOF
fi

echo ".env listo."

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
