<?php

namespace App\Http\Controllers\Auth\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\Admin\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

/**
 * 管理者ユーザー用の認証セッションコントローラー
 * ログイン画面表示・認証処理・ログアウト処理を担当
 */
class AuthenticatedSessionController extends Controller
{
    /**
     * 管理者ログイン画面を表示
     * GET /admin/login
     */
    public function create(): View
    {
        return view('auth/admin/login');
    }

    /**
     * 管理者ログイン処理
     * POST /admin/login
     * LoginRequestのバリデーション・認証を実行後、書籍一覧へリダイレクト
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // LoginRequest::authenticate()でadminガード認証を実行
        $request->authenticate();
        // セッション固定化攻撃対策のためセッションIDを再生成
        $request->session()->regenerate();
        return redirect(route('book.index'));
    }

    /**
     * 管理者ログアウト処理
     * POST /admin/logout
     * セッションを破棄してログイン画面へリダイレクト
     */
    public function destroy(Request $request): RedirectResponse
    {
        // 現在のガードからログアウト
        Auth::logout();
        // セッションを無効化してトークンを再生成（CSRF対策）
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect(route('admin.create'));
    }
}
