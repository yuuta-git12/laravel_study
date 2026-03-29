<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // 認証に利用するモデルに必要なライブラリ

class Admin extends Authenticatable
{
    //
    use HasFactory;

    // パスワードはhhidden設定されたフィールドはモデルが配列やJSONに変換されるときに隠蔽される
    protected $hidden = [
        'password',
    ];
}
