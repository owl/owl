#!/bin/sh

# download composer.phar
curl -sS https://getcomposer.org/installer | php

# install libraries
php composer.phar install --no-dev

# prepare files
cp storage/database.sqlite_default storage/database.sqlite
chmod -R 777 storage/

# database migration
php artisan migrate --seed --force
php artisan vendor:publish --provider="Owl\Providers\TwitterBootstrapServiceProvider"

# run npm build
npm i
npm run build
