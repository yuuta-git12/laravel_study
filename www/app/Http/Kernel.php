<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array<int, class-string|string>
     */
    protected $middleware = [
        \App\Http\Middleware\AccessLogger::class,               // アクセスログ記録（独自追加）
        // \App\Http\Middleware\TrustHosts::class,             // 信頼するホストの制限（無効化中）
        \App\Http\Middleware\TrustProxies::class,              // リバースプロキシからのIPを信頼
        \Illuminate\Http\Middleware\HandleCors::class,         // CORSヘッダーの付与
        \App\Http\Middleware\PreventRequestsDuringMaintenance::class, // メンテナンスモード時のアクセス制限
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class, // POSTデータサイズの上限チェック
        \App\Http\Middleware\TrimStrings::class,               // 入力文字列の前後スペース除去
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class, // 空文字列をnullに変換
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array<string, array<int, class-string|string>>
     */
    protected $middlewareGroups = [
        // routes/web.php の全ルートに自動適用されるグループ
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,                  // Cookieの暗号化・復号
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class, // キューされたCookieをレスポンスへ追加
            \Illuminate\Session\Middleware\StartSession::class,          // セッションの開始
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,   // バリデーションエラーをビューに共有
            \App\Http\Middleware\VerifyCsrfToken::class,                 // CSRFトークンの検証
            \Illuminate\Routing\Middleware\SubstituteBindings::class,   // ルートモデルバインディングの解決
        ],

        // routes/api.php の全ルートに自動適用されるグループ
        'api' => [
            // \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class, // SPA認証（無効化中）
            \Illuminate\Routing\Middleware\ThrottleRequests::class.':api', // APIレート制限
            \Illuminate\Routing\Middleware\SubstituteBindings::class,   // ルートモデルバインディングの解決
        ],
    ];

    /**
     * The application's middleware aliases.
     *
     * Aliases may be used instead of class names to conveniently assign middleware to routes and groups.
     *
     * @var array<string, class-string|string>
     */
    // ルートでエイリアス名で指定できるミドルウェアの一覧
    // 例: ->middleware('auth') や ->middleware('auth:admin') のように使用
    protected $middlewareAliases = [
        'auth' => \App\Http\Middleware\Authenticate::class,                         // 認証チェック（未認証ならログイン画面へ）
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class, // HTTP Basic認証
        'auth.session' => \Illuminate\Session\Middleware\AuthenticateSession::class, // セッションによる認証維持
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,      // レスポンスのキャッシュヘッダー設定
        'can' => \Illuminate\Auth\Middleware\Authorize::class,                      // ポリシーによる認可チェック
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,             // ログイン済みならホームへリダイレクト
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,   // パスワード再確認を要求
        'precognitive' => \Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests::class, // 事前リクエスト処理
        'signed' => \App\Http\Middleware\ValidateSignature::class,                  // 署名付きURLの検証
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,       // レート制限
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,     // メール認証済みチェック
    ];
}
