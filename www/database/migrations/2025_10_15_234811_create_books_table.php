<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title',100);
            $table->string('author',50);
            $table->integer('price');
            $table->foreignId('category_id')->constrained('categories'); // カテゴリID 型:int 外部キー テーブル名:categories
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');  // 引数のテーブルが存在する場合、削除
    }
};
