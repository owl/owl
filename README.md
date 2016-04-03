# Owl [![Build Status](https://travis-ci.org/owl/owl.svg?branch=master)](https://travis-ci.org/owl/owl) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/owl/owl/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/owl/owl/?branch=master)

Owl is a simple team collaboration tool.  
This software is released under the MIT License, see LICENSE.txt.

![screenshot](https://raw.githubusercontent.com/wiki/fortkle/owl/images/owl_screenshot.png)

## Feature

- Markdown
- Syntax Highlight
- Like button
- Comment
- Favorite
- Tags
- Full Text Search
- Item Publishing Settings (Public, Limited, Only Me)
- Mail Notification
- Slack Notification(webhook)
- Export data as .md files (YAML front matter)

# Demo

[http://demo-owl.fortkle.com/](http://demo-owl.fortkle.com/)  

Data will be deleted in a few months.

# How to use

## Requirements

- PHP 5.4
  - php-mcrypt
  - php-mbstring
  - pdo-sqlite
  - openssl
- SQLite 3
- npm

## Install
1.Clone the project

```
$ git clone https://github.com/owl/owl.git
$ cd owl
```

2.execute setup shell

```
$ sh ./setup_app.sh
```

3.Access the page

```
php artisan serve --host 0.0.0.0 --port 3000
```

access http://localhost:3000

You can sign in as an owner with id:admin pw:password

## Update
1.git pull latest update_app.sh

```
$ git pull origin master
```

2.execute update shell

```
$ sh ./update_app.sh
```

## Documentation
[Owl Documentation](https://github.com/owl/owl/wiki)
※ Sorry, Japanese Only.

# How To Contribute
Please see [CONTRIBUTE.md](https://github.com/owl/owl/blob/master/CONTRIBUTE.md)

