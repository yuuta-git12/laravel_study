# Laravel Breeze 導入トラブルシューティング記録

## 概要

Docker環境のLaravel 12プロジェクトにLaravel Breezeを導入する際に発生した問題と解決手順をまとめる。

---

## 1. `composer require laravel/breeze --dev` が失敗する

### エラー内容

```
Root composer.json requires nunomaduro/collision ^9.0,
found nunomaduro/collision[v0.1.0, ..., v8.x-dev] but it does not match the constraint.
```

### 原因

Dockerイメージビルド時にインストールされたComposerが古く、パッケージリポジトリの解決に失敗していた。
`nunomaduro/collision ^9.0` が見つからない状態。

### 解決方法

コンテナ内でComposerを最新版に更新してから再実行した。

```bash
docker compose exec app composer self-update
docker compose exec app composer require laravel/breeze --dev
```

---

## 2. `Vite manifest not found at: /var/www/html/build/manifest.json`

### エラー内容

Breezeインストール後、ページにアクセスすると以下のエラーが表示された。

```
Vite manifest not found at: /var/www/html/build/manifest.json
```

### 原因

Breezeの Bladeテンプレート（`resources/views/layouts/guest.blade.php` 等）で `@vite()` ディレクティブが使用されているが、Viteのビルドがまだ実行されておらず `manifest.json` が存在しなかった。

さらに、このプロジェクトではLaravelの公開ディレクトリがデフォルトの `public` ではなく **`html`** にカスタマイズされていた（`bootstrap/app.php` の `$app->usePublicPath(base_path('html'))`）。そのため `@vite()` は `html/build/manifest.json` を探すが、Viteのデフォルト出力先は `public/build` であり、パスが一致しなかった。

### 解決方法

`vite.config.js` のビルド出力先を `html/build` に変更した。

```js
// vite.config.js
export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    build: {
        outDir: 'html/build',
    },
});
```

変更後にビルドを実行。

```bash
docker compose exec app npm install
docker compose exec app npm run build
```

---

## 3. `npm run dev` がDocker環境で動作しない

### 原因

`npm run dev`（Vite devサーバー）はホットリロード用の開発サーバーを起動するが、Docker環境ではネットワーク構成（ポートバインド、ホスト設定）の問題があり、ブラウザからVite devサーバーに正しく接続できない。

### 結論

このDocker構成では `npm run dev` ではなく **`npm run build`** を使う。CSS/JSを変更するたびに再ビルドする運用とする。

```bash
docker compose exec app npm run build
```

---

## プロジェクト固有の注意点

| 項目 | デフォルト | このプロジェクト |
|------|-----------|-----------------|
| 公開ディレクトリ | `public` | `html` |
| DocumentRoot | `/var/www/public` | `/var/www/html` |
| public_path設定 | なし | `bootstrap/app.php` で `$app->usePublicPath(base_path('html'))` |
| Viteビルド出力先 | `public/build` | `html/build`（`vite.config.js` で変更） |

## 関連ファイル

- `bootstrap/app.php` — 公開ディレクトリの設定（`usePublicPath`）
- `vite.config.js` — Viteビルド設定（`outDir`）
- `docker/app/apache2/sites-available/000-default.conf` — Apache DocumentRoot設定
- `docker/app/Dockerfile` — Composer / Node.js のインストール
- `resources/views/layouts/guest.blade.php` — `@vite()` ディレクティブ使用箇所
