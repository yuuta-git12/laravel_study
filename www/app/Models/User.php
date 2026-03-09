<?php

namespace App\Models;

// メール認証を必須にするためのインターフェース
use Illuminate\Contracts\Auth\MustVerifyEmail;
// モデルファクトリ（テストデータ生成）を使用するためのトレイト
use Illuminate\Database\Eloquent\Factories\HasFactory;
// Laravel標準の認証ユーザーモデル基底クラス
use Illuminate\Foundation\Auth\User as Authenticatable;
// メール通知などの通知機能を使用するためのトレイト
use Illuminate\Notifications\Notifiable;
// SanctumによるAPIトークン認証を使用するためのトレイト
use Laravel\Sanctum\HasApiTokens;

/**
 * ユーザーモデル
 *
 * usersテーブルに対応するEloquentモデル
 * Laravel Breezeによる認証機能の基盤となるモデルで、
 * メール認証（MustVerifyEmail）を必須としている
 */
class User extends Authenticatable implements MustVerifyEmail
{
    // APIトークン認証・ファクトリ・通知機能を有効化
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Mass Assignment で代入を許可するカラム
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',     // ユーザー名
        'email',    // メールアドレス
        'password', // パスワード
    ];

    /**
     * JSON・配列へのシリアライズ時に非表示にするカラム
     *
     * APIレスポンスなどにパスワードやトークンが含まれないようにする
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',       // パスワード
        'remember_token', // ログイン保持用トークン
    ];

    /**
     * カラムの型キャスト定義
     *
     * データベースから取得した値を自動的に指定した型に変換する
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime', // メール認証日時をCarbonインスタンスに変換
        'password' => 'hashed',            // パスワードを自動的にハッシュ化
    ];
}
