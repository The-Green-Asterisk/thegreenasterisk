cd /usr/local/var/www/thegreenasterisk
git pull origin main
composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader
php artisan migrate --force
npm run build