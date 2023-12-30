date > public/update.txt
cd /usr/local/var/www/thegreenasterisk >> public/update.txt
git pull origin main >> public/update.txt
composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader >> public/update.txt
php artisan migrate --force >> public/update.txt
npm run build >> public/update.txt
php artisan cache:clear >> public/update.txt
php artisan route:cache >> public/update.txt
date >> public/update.txt