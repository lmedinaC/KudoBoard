#!/bin/sh

set -e

echo 'running prestart apache script'

echo 'running composer install'
composer install

php artisan cache:clear
php artisan config:clear
php artisan config:cache
php artisan migrate:refresh

php artisan db:seed

php artisan storage:link

echo 'initialization done, starting apache'
exec apache2-foreground