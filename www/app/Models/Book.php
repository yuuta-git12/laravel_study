<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * 書籍モデル
 *
 * 書籍テーブルに対応するEloquentモデル
 * カテゴリとの1対多、著者との多対多のリレーションを持つ
 */
class Book extends Model
{
    use HasFactory; // ファクトリを使用するための宣言

    /**
     * Mass Assignment で代入を許可するカラム
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'category_id',
        'title',
        'price',
    ];

    /**
     * 著者とのリレーション（多対多）
     *
     * 書籍1件に複数の著者が紐づく
     * 中間テーブル: author_book
     *
     * @return BelongsToMany<Author>
     */
    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(Author::class)->withTimestamps();
    }

    /**
     * カテゴリとのリレーション（多対1）
     *
     * 書籍は1つのカテゴリに属する
     *
     * @return BelongsTo<Category, Book>
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
