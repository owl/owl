# Owl [![Build Status](https://travis-ci.org/fortkle/owl.svg?branch=master)](https://travis-ci.org/fortkle/owl)

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
git clone https://github.com/fortkle/owl.git
cd owl
```

2.Composer

```
curl -sS https://getcomposer.org/installer | php
php composer.phar install
```

3.Database migration

```
php artisan migrate --package=cartalyst/sentry
php artisan migrate
```

if you need a seed data (optional)

```
php artisan db:seed
```

4.Access the page

```
php artisan serve --host 0.0.0.0 --port 3000
```

access http://localhost:3000  



## Test
Rspec + Capybara + PhantomJS（Poltergeist）

※ PhantomJS required  
https://github.com/teampoltergeist/poltergeist

1.gem install

```
$ bundle install --path vendor/bundle
```

2.fix settings

```
$ vim spec/spec_helper.rb
```
please change host.

3.run test
move root directory.

```
$ bundle exec rspec spec
```
