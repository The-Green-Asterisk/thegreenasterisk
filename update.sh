echo $(date +"%Y-%m-%d %T")
cd /usr/local/var/www/thegreenasterisk
git pull origin main
composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader
php artisan migrate --force
npm run build
php artisan cache:clear
php artisan route:cache
echo $(date +"%Y-%m-%d %T")