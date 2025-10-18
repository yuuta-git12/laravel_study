<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // テーブル名を指定
    protected $fillable = ['title'];    // フィルタリングを許可 createメソッドで使用
}
