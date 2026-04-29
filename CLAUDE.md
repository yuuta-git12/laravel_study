# CLAUDE.md

このファイルは Claude Code がこのリポジトリで作業する際に参照するガイドです。

## プロジェクト概要

Laravel 12.x を使用した学習用リポジトリ。Docker (カスタム構成) で環境を管理する。

## 技術スタック

- **Laravel**: 12.x
- **PHP**: 8.3
- **DB (本番)**: MariaDB 11.3
- **DB (テスト)**: SQLite インメモリ (`:memory:`)
- **Web Server**: Apache 2.4
- **Node.js**: 20.x / Vite 5

## ディレクトリ構成

```
laravel_study/
├── docker/            # Docker関連ファイル
├── www/               # Laravelアプリ本体
│   ├── app/
│   │   ├── Http/Controllers/
│   │   │   ├── Auth/          # 一般ユーザー認証コントローラ
│   │   │   ├── Admin/         # 管理者コントローラ
│   │   │   └── MessageController.php
│   │   └── Models/            # Admin, Author, Book, Category, Message, User など
│   ├── database/
│   ├── resources/
│   ├── routes/
│   └── tests/
│       ├── Feature/
│       │   ├── Auth/Admin/    # 管理者認証テスト
│       │   └── MessageTest.php
│       └── Unit/
└── docker-compose.yml
```

## コマンド実行の注意点

**Laravel Sail は使用していない。** 必ず `docker-compose exec app` 経由でコマンドを実行すること。

```bash
# 正しい
docker-compose exec app php artisan [command]
docker-compose exec app composer [command]
docker-compose exec app npm [command]

# 間違い（使用不可）
sail artisan [command]
```

## よく使うコマンド

```bash
# コンテナ起動
docker-compose up -d --build

# マイグレーション
docker-compose exec app php artisan migrate

# シーダー実行
docker-compose exec app php artisan db:seed

# テスト実行（SQLiteインメモリで高速実行）
docker-compose exec app php artisan test
# または
docker-compose exec app ./vendor/bin/phpunit

# ルート一覧
docker-compose exec app php artisan route:list

# キャッシュクリア
docker-compose exec app php artisan cache:clear

# フロントエンド開発サーバー
docker-compose exec app npm run dev
```

## テスト

- テスト用DBは SQLite インメモリ (`:memory:`) を使用 (`phpunit.xml` で設定済み)
- `RefreshDatabase` trait でテストごとにDBリセット
- 管理者認証は `admin` ガードを使用 (`assertAuthenticatedAs($user, 'admin')`)
- テストファイルは `www/tests/Feature/` 以下に配置

## 認証

- 一般ユーザー認証: デフォルトの `web` ガード (`User` モデル)
- 管理者認証: `admin` ガード (`Admin` モデル、`Authenticatable` を継承)

## アクセスURL

| サービス | URL |
|---|---|
| Laravelアプリ | http://localhost または http://localhost:8000 |
| phpMyAdmin | http://localhost:8080 |
| Vite開発サーバー | http://localhost:5173 |

## DB接続情報（開発用）

```
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=study_db_name
DB_USERNAME=study_user
DB_PASSWORD=study_pass
```

## プロンプト
- 今日の内容を記録して　→ `/TodayHistory`ディレクトリにその日やったことを記録する