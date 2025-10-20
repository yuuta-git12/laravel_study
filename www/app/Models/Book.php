<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Book extends Model
{
    //
    use HasFactory; // ファクトリを使用するための宣言

    // 多対多のリレーション設定
    // 書籍1件に複数の著者が紐づく
    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(Author::class)->withTimestamps();
    }

    // 1対多のリレーション
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
