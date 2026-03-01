/**
 * Vite設定ファイル
 *
 * フロントエンドアセット（CSS・JS）のビルドとホットリロードを管理する
 * Laravel Viteプラグインを使用してLaravelと連携する
 */
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            // ビルド対象のエントリーポイント（CSSとJS）
            input: ['resources/css/app.css', 'resources/js/app.js'],
            // ファイル変更時にブラウザを自動リロードする
            refresh: true,
        }),
    ],
    build: {
        // ビルド出力先ディレクトリ（ApacheのDocumentRoot配下に出力）
        outDir: 'html/build',
    },
});
