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

## 起動
```
cd athena
php artisan serve --host 0.0.0.0 --port 3000
```

http://localhost:3000 にアクセスし、「You have arrived.」が表示される事を確認。
