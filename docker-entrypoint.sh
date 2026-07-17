#!/bin/bash
set -e

echo "Starting Docker Entrypoint..."

# Wait a few seconds for DB to be ready
echo "Waiting for database..."
sleep 5

# Run Migrations first so the cache table exists
echo "Running database migrations..."
php artisan migrate --force

# Clear Laravel caches
echo "Clearing caches..."
php artisan config:clear
php artisan cache:clear
php artisan view:clear

# Start the main process (Apache)
echo "Starting web server..."
exec "$@"
