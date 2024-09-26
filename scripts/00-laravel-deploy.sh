#!/usr/bin/env bash
echo "Running composer"
composer install --working-dir=/var/www/html

npm run prod

echo "Caching config..."
php artisan config:cache

echo "Caching routes..."
php artisan route:cache

echo "Running migrations..."
php artisan migrate --force --seed