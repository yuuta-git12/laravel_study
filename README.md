# PHP_STUDY

## 説明
- 独習PHP第４版の内容を実行するためのリポジトリ

## 学習用の開発環境
- 以下の環境をDockerで構築
  - サーバー：Apache 最新バージョン
  - プログラミング言語：PHP　バージョン8以降
    - インストールする拡張モジュール
      - OPcache(https://www.php.net/manual/ja/intro.opcache.php)
      - intl(https://www.php.net/manual/ja/book.intl.php)
      - GD(https://www.php.net/manual/ja/book.image.php)
      - Exif(https://www.php.net/manual/ja/book.exif.php)
      - Imagick(https://www.php.net/manual/ja/book.imagick.php)
      - mysqli(https://www.php.net/manual/ja/book.mysqli.php)
      - pdo_mysql(https://www.php.net/manual/ja/book.pdo.php)
      - redis()
      - xdebug(https://xdebug.org)
  - データーベース：postgresql
  - 
## 拡張機能
- Emmmet:入力の効率化用プラグイン html:5でhtmlのページの外枠が一気に入力できる

## 参考
- 開発環境構築の参考サイト
  - [Docker で Apache + PHP コンテナを作る方法](https://lazesoftware.com/ja/blog/230220/)
  - [DockerでApache+PHP+MySQLの環境を構築してみる](https://qiita.com/me-654393/items/1ed212cb33eafe734835)
  - https://zenn.dev/ikuraikura/articles/d166724f2c123d1db312
  - https://zenn.dev/dragonarrow/articles/b3fbdf1718a812
- Apacheの参考サイト
  - [a2enmodとa2dismodコマンドの動作について](https://web.just4fun.biz/?Apache/a2enmodとa2dismodコマンドの動作について)
  - [mod_rewriteとは](https://qiita.com/miyuki_samitani/items/b22e1738b2737c655785)
  - [Apache deflate,exporesについて](https://serverlog.jp/apache2-2/)