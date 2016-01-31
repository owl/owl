#!/bin/sh

# download composer.phar
curl -sS https://getcomposer.org/installer | php

# install libraries
php composer.phar install

# prepare files
cp .env.example .env
php artisan key:generate

cp storage/database.sqlite_default storage/database.sqlite
chmod -R 777 storage/

# database migration
php artisan migrate --seed --force

# run npm build
npm i
npm run build
