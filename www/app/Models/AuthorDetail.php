<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuthorDetail extends Model
{
    //
    use HasFactory; // ファクトリを使用するための宣言

    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class)->withTimestamps();
    }

    // ID以外が主キーになっているので$primaryKeyを定義する
    protected $primaryKey = 'author_id';

    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }
}
