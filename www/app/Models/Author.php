<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Author extends Model
{
    use HasFactory; // ファクトリを使用するための宣言

    public function books()
    {
        return $this->belongsToMany(Book::class);
    }

    //著者詳細テーブルとの1対1のリレーション
    public function detail():HasOne
    {
        return $this->hasOne(AuthorDetail::class);
    }

}
