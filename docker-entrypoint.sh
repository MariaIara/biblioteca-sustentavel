#!/bin/bash
set -e

# Cria o symlink de storage (necessário para capas de livros)
php artisan storage:link 2>/dev/null || true

# Roda as migrations automaticamente a cada deploy
php artisan migrate --force

# Cache de configuração/rotas/views para produção
php artisan config:cache
php artisan route:cache
php artisan view:cache

exec "$@"
