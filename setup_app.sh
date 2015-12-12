#!/bin/sh

# download composer.phar
curl -sS https://getcomposer.org/installer | php

# install libraries
php composer.phar install

# prepare files
mv storage/database.sqlite_default storage/database.sqlite

# database migration
php artisan migrate --seed
php artisan vendor:publish --provider="Owl\Providers\TwitterBootstrapServiceProvider"
