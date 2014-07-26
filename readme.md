# Athena Project [![Build Status](https://travis-ci.org/fortkle/athena.svg?branch=master)](https://travis-ci.org/fortkle/athena)

## Concept
Athena is a simple team collaboration tool.  

## Release Scheduled
2014/8/15  

## Development setup
1.composer   
```
curl -sS https://getcomposer.org/installer | php  
php composer.phar install  
```

2.database settings  
application/config/database.php  

3.initialization  
```
// Sentry
php artisan migrate --package=cartalyst/sentry  
php artisan config:publish cartalyst/sentry  

// change default settings
// app/config/packages/cartalyst/sentry/config.php LINE:136
'login_attribute' => 'username',  

// migration
php artisan migrate
php artisan db:seed
```
migration
```
cd athena
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
