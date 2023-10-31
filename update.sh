cd /usr/local/var/www/thegreenasterisk
git pull origin main

composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

if [ -f artisan ]; then
    php artisan migrate --force
fi
npm run build
