<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * 著者・書籍 中間テーブルのマイグレーション
 *
 * booksテーブルとauthorsテーブルの多対多リレーションを管理する中間テーブルを作成する
 */
return new class extends Migration
{
    /**
     * マイグレーション実行（テーブル作成）
     */
    public function up(): void
    {
        Schema::create('author_book', function (Blueprint $table) {
            // booksテーブルへの外部キー（書籍削除時に中間テーブルのレコードも連動削除）
            $table->foreignId('book_id')->contrained('books')->cascadeOnDelete();
            // authorsテーブルへの外部キー
            $table->foreignId('author_id')->contrained('authors');
            $table->timestamps();

            // 主キーをbook_idとauthor_idに設定(複合主キー)
            $table->primary(['book_id', 'author_id']);
        });
    }

    /**
     * マイグレーションのロールバック（テーブル削除）
     */
    public function down(): void
    {
        Schema::dropIfExists('author_book');
    }
};
