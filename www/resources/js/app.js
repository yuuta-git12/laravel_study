/**
 * アプリケーションのメインJavaScriptファイル
 *
 * 共通ライブラリの読み込みとAlpine.jsの初期化を行う
 */

// 共通ライブラリの読み込み（axios等のHTTPクライアント設定）
import './bootstrap';

// Alpine.js: 軽量なリアクティブフレームワーク（ドロップダウンやモーダル等のUI制御に使用）
import Alpine from 'alpinejs';

// Alpine.jsをグローバルに登録し、初期化する
window.Alpine = Alpine;
Alpine.start();
