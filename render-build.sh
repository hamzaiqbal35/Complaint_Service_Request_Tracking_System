#!/usr/bin/env bash
# exit on error
set -o errexit

echo "Installing PHP dependencies..."
composer install --no-dev --optimize-autoloader

echo "Installing Node dependencies..."
npm install

echo "Building frontend assets..."
npm run build

echo "Clearing configuration cache..."
php artisan config:clear
php artisan cache:clear
php artisan view:clear

echo "Running migrations..."
php artisan migrate --force

echo "Deployment build completed successfully!"
