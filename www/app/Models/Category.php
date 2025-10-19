<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory; // ファクトリを使用するための宣言
    // テーブル名を指定
    protected $fillable = ['title'];    // フィルタリングを許可 createメソッドで使用
}
