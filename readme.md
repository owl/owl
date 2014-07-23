# Athena Project
[![Build Status](https://travis-ci.org/fortkle/athena.svg?branch=master)](https://travis-ci.org/fortkle/athena)

## コンセプト
「簡単に書けて、見れて、調べることができる情報共有コラボレーションツール」

## なぜ作るのか
気軽でかんたんに情報共有をする文化を創るため

## 開発における判断基準
・かんたんに書けるか  
・かんたんに見れるか  
・かんたんに調べられるか  

## リリース予定日
2014/8/15

## 参考サイト・サービス
・Qiita:Team https://teams.qiita.com/  
・gamba! http://www.getgamba.com/top  
・はてなグループ http://g.hatena.ne.jp/  

## How to Install
1.必要なライブラリをインストール  
```
curl -sS https://getcomposer.org/installer | php  
php composer.phar install  
```

2.データベース設定(個人のローカルのmysqlで)  
application/config/database.php

3.初期設定  
```
// Sentry
php artisan migrate --package=cartalyst/sentry  
php artisan config:publish cartalyst/sentry  
// マイグレーション
php artisan migrate
php artisan db:seed
```

4.起動
```
cd athena
php artisan serve --host 0.0.0.0 --port 3000
```
http://localhost:3000 にアクセスし、ログイン画面が表示される事を確認。  


5.基本グループと初期ユーザーを作成
http://localhost:3000/setup/index にアクセスし、リンク押下  


## テスト
テストには、Rspec + Capybara + PhantomJS（Poltergeist）を使っています。
PhantomJSは公式サイトからバイナリを落としてきてパスを通して下さい。
※参考
PhantomJSのインストール
https://github.com/teampoltergeist/poltergeist

1.gemのインストール
```
$ bundle install --path vendor/bundle
```

2.設定ファイルの修正
```
$ vim spec/spec_helper.rb
```
hostを変更して下さい。

3.テストを実行
appやspecなどがあるルートディレクトリに移動。
```
$ bundle exec rspec spec
```
