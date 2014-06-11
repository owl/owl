# Athena Project
## コンセプト
「簡単に書けて、見れて、調べることができる情報共有コラボレーションツール」

## なぜ作るのか
気軽でかんたんに情報共有をする文化を創るため

## 開発における判断基準
・かんたんに書けるか  
・かんたんに見れるか  
・かんたんに調べられるか  

## リリース予定日
2014/6/30

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

