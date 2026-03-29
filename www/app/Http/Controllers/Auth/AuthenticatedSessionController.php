<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     * ログイン画面の表示処理
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     * ログインボタンクリック時のリクエストを受け付け
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // 認証処理
        $request->authenticate();

        // ログインのたびにセッションIDを再発行
        $request->session()->regenerate();

        // ホーム画面にリダイレクト
        //www/app/Providers/RouteServiceProvider.phpで定義されているHOMEにリダイレクト
        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     * ログアウトの処理
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
