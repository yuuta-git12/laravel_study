<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * メッセージを表すモデル
 */
class Message extends Model
{
    // $fillable: 一括代入（Mass Assignment）を許可するカラムを指定
    // Message::create(['body' => '...']) のように使用できるようになる
    protected $fillable = ['body'];
}
