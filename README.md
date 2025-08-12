# Laravel 学習用リポジトリ

このリポジトリは、Laravel 12.xを使用した学習・開発環境です。Dockerを使用して簡単に環境を構築できます。

## 🚀 技術スタック

- **Laravel**: 12.x
- **PHP**: 8.3
- **MySQL**: MariaDB 11.3
- **Web Server**: Apache 2.4
- **Node.js**: 20.x
- **npm**: 最新版
- **Vite**: 5.0.0
- **phpMyAdmin**: 最新版
- **Docker**: Docker Compose

## 📁 プロジェクト構成

```
laravel_study/
├── docker/                    # Docker関連ファイル
│   ├── app/                   # PHP + Apache環境
│   │   ├── Dockerfile         # PHP 8.3 + Apache設定
│   │   ├── php.ini           # PHP設定ファイル
│   │   └── apache2/          # Apache設定
│   └── mysql/                # MySQL環境
│       ├── Dockerfile        # MariaDB設定
│       ├── server.cnf        # MySQL設定ファイル
│       └── storage/          # データベースファイル
├── www/                      # Laravelアプリケーション
│   ├── app/                  # アプリケーションロジック
│   ├── config/               # Laravel設定ファイル
│   ├── database/             # マイグレーション・シーダー
│   ├── resources/            # ビュー・アセット
│   ├── routes/               # ルーティング
│   ├── storage/              # ファイルストレージ
│   ├── package.json          # npm依存関係
│   └── vite.config.js        # Vite設定
└── docker-compose.yml        # Docker環境設定
```

## 🐳 Docker環境

### サービス構成

| サービス | ポート | 説明 |
|---------|--------|------|
| **app** | 80, 8000, 5173 | PHP 8.3 + Apache + Laravel + Node.js |
| **mysql** | 3306 | MariaDB 11.3 データベース |
| **phpmyadmin** | 8080 | phpMyAdmin（データベース管理） |

### 環境変数

#### データベース設定
- **データベース名**: `study_db_name`
- **ユーザー名**: `study_user`
- **パスワード**: `study_pass`
- **ルートパスワード**: `studt_root_pass`

## 🚀 起動方法

### 1. 環境の起動

```bash
# Dockerコンテナをビルドして起動
docker-compose up -d --build
```

### 2. 依存関係のインストール

```bash
# Composer依存関係をインストール
docker-compose exec app composer install

# npm依存関係をインストール
docker-compose exec app npm install
```

### 3. 環境設定

```bash
# 環境設定ファイルの作成
docker-compose exec app cp .env.example .env

# アプリケーションキーの生成
docker-compose exec app php artisan key:generate

# データベース設定の確認（必要に応じて修正）
docker-compose exec app cat .env | grep -E "(DB_|APP_)"
```

### 4. データベースのセットアップ

```bash
# マイグレーションの実行
docker-compose exec app php artisan migrate

# シーダーの実行（オプション）
docker-compose exec app php artisan db:seed
```

## 🌐 アクセス方法

| サービス | URL | 説明 |
|---------|-----|------|
| **Laravelアプリ** | http://localhost | メインアプリケーション |
| **Laravelアプリ** | http://localhost:8000 | 代替ポート |
| **phpMyAdmin** | http://localhost:8080 | データベース管理 |
| **Vite開発サーバー** | http://localhost:5173 | フロントエンド開発 |

## 🛠️ 開発コマンド

### Laravelコマンド

```bash
# アーティザンコマンドの実行
docker-compose exec app php artisan [command]

# 例：ルート一覧の表示
docker-compose exec app php artisan route:list

# 例：キャッシュのクリア
docker-compose exec app php artisan cache:clear
```

### Composerコマンド

```bash
# パッケージのインストール
docker-compose exec app composer require [package]

# 依存関係の更新
docker-compose exec app composer update
```

### フロントエンド開発

```bash
# npmコマンドの実行
docker-compose exec app npm [command]

# 例：依存関係のインストール
docker-compose exec app npm install

# 例：開発サーバーの起動
docker-compose exec app npm run dev

# 例：本番ビルド
docker-compose exec app npm run build
```

## ⚠️ 重要な注意事項

### Laravel Sailについて
このプロジェクトでは**Laravel Sailは使用していません**。代わりにカスタムDocker環境を使用しています。

- ❌ `sail up` や `sail artisan` などのコマンドは使用できません
- ✅ `docker-compose exec app` を使用してコンテナ内でコマンドを実行します

### 正しいコマンド例
```bash
# ❌ 間違い
sail up
sail artisan migrate
sail npm install

# ✅ 正しい
docker-compose up -d
docker-compose exec app php artisan migrate
docker-compose exec app npm install
```

## 📝 設定ファイル

### 主要な設定ファイル

- **`docker-compose.yml`**: Docker環境の全体設定
- **`docker/app/Dockerfile`**: PHP 8.3 + Apache + Node.js環境の構築
- **`docker/mysql/Dockerfile`**: MariaDB環境の構築
- **`www/.env`**: Laravel環境設定
- **`www/config/`**: Laravel設定ファイル群
- **`www/package.json`**: npm依存関係
- **`www/vite.config.js`**: Vite設定

### データベース設定

```env
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=study_db_name
DB_USERNAME=study_user
DB_PASSWORD=study_pass
```

## 🔧 トラブルシューティング

### よくある問題

1. **ポートが使用中の場合**
   ```bash
   # 使用中のポートを確認
   lsof -i :80
   lsof -i :3306
   lsof -i :5173
   ```

2. **Dockerコンテナが起動しない場合**
   ```bash
   # ログの確認
   docker-compose logs
   
   # コンテナの再ビルド
   docker-compose down
   docker-compose up -d --build
   ```

3. **データベース接続エラー**
   ```bash
   # データベースコンテナの確認
   docker-compose ps mysql
   
   # データベースログの確認
   docker-compose logs mysql
   ```

4. **npmコマンドが実行できない場合**
   ```bash
   # Node.jsがインストールされているか確認
   docker-compose exec app node --version
   docker-compose exec app npm --version
   
   # コンテナを再ビルド（Node.jsが追加された場合）
   docker-compose down
   docker-compose build --no-cache
   docker-compose up -d
   ```

## 📚 学習リソース

- [Laravel公式ドキュメント](https://laravel.com/docs)
- [Laravel 12.x新機能](https://laravel.com/docs/12.x)
- [Vite公式ドキュメント](https://vitejs.dev/)
- [Docker公式ドキュメント](https://docs.docker.com/)

## 🤝 貢献

このリポジトリは学習用です。改善提案やバグ報告は歓迎します。

## 📄 ライセンス

MIT License