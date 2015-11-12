# Owl [![Build Status](https://travis-ci.org/owl/owl.svg?branch=master)](https://travis-ci.org/owl/owl)

Owl is a simple team collaboration tool.  
This software is released under the MIT License, see LICENSE.txt.

![screenshot](https://raw.githubusercontent.com/wiki/fortkle/owl/images/owl_screenshot.png)

## Feature

- Markdown
- Syntax Highight
- Like button
- Comment
- Stock (favorite)
- Tags
- Full Text Search
- Item Publishing Settings (Public, Limited, Only Me)

## Requirements

- PHP 5.4
- SQLite 3


# For Developer
## Development setup
1.Clone the project

```
git clone https://github.com/owl/owl.git
cd owl
```

2.Composer

```
curl -sS https://getcomposer.org/installer | php
php composer.phar install
```

3.Database migration

```
php artisan migrate
php artisan vendor:publish --provider="Owl\Providers\TwitterBootstrapServiceProvider"
```

4.Access the page

```
php artisan serve --host 0.0.0.0 --port 3000
```

access http://localhost:3000  

You can sign in as a Owner with id:admin pw:password

## Test
Behat acceptance test
(after `composer install`)

```
$ vendor/bin/behat --colors
```
