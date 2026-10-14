#!/bin/bash
set -e

echo "Starting Docker Entrypoint..."

# Wait a few seconds for DB to be ready
echo "Waiting for database..."
sleep 5

# Clear cached configuration
echo "Clearing cached configuration..."
php artisan config:clear

# Run Migrations first so tables exist
echo "Running database migrations..."
php artisan migrate --force

# Seed admin if requested
if [ "${SEED_ADMIN:-false}" = "true" ]; then
    echo "Creating initial admin account..."
    php artisan db:seed --class=AdminSeeder --force
fi

# Clear Laravel caches
echo "Clearing views and caches..."
php artisan cache:clear
php artisan view:clear

# Start the main process (Apache)
echo "Starting web server..."
exec "$@"
