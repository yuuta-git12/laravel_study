<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{

    // ガード名ごとのログイン済みリダイレクト先マップ
    // 'admin'ガード → 管理者ホーム、デフォルト(null/'') → 一般ユーザーホーム
    private const HOMES = [
        'admin' => RouteServiceProvider::ADMIN_HOME,
        '' => RouteServiceProvider::HOME,
    ];

    /**
     * Handle an incoming request.
     * すでにログイン済みのユーザーがログインページにアクセスした場合、適切なホームへリダイレクト
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        // ガードが指定されていない場合はデフォルトガード(null)を使用
        $guards = empty($guards) ? [null] : $guards;    // ミドルウェア設定時に指定したガード名が代入

        foreach ($guards as $guard) {
            // 指定ガードで認証済みの場合、対応するホーム画面へリダイレクト
            if (Auth::guard($guard)->check()) {
                return redirect(self::HOMES[$guard]);
            }
        }

        // 未認証の場合はそのままリクエストを続行
        return $next($request);
    }
}
