FROM php:8.2-apache

# ドキュメントルートを変更
ENV APACHE_DOCUMENT_ROOT /path/to/new/root
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Apacheのモジュールを有効化(ここではmod_deflate,mod_expires,mod_rewriteを有効化)
# deflateはサーバ→クライアントでやり取りするデータを圧縮することができる
# expiresはブラウザキャッシュ機能を追加する
# rrewriteはアクセスURLを正規表現で書き換える機能
RUN a2enmod deflate expires rewrite


# install-php-extensionsコマンドをインストール(PHPのエクステンションインストールに必要)
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod +x /usr/local/bin/install-php-extensions

# PHPのエクステンション(拡張モジュール)をインストール
RUN install-php-extensions opcache intl gd exif imagick mysqli pdo_mysql redis xdebug

# PHPの設定ファイルを配置
# 644 所有者の権限：読み込み・書き込みどちらも可　グループの権限：読み込みのみ可　その他のユーザー：読込のみ可
COPY /config/php/php.ini /usr/local/etc/php/
RUN chmod 644 /usr/local/etc/php
