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
        Schema::create('author_details', function (Blueprint $table) {
            $table->foreignId('author_id')->constrained('authors'); // 作者ID 型:int 外部キー テーブル名:authors
            $table->string('email',100)->nullable()->unique(); // メールアドレス 型:varchar(100) ユニーク
            $table->string('address',100)->nullable(); // 住所 型:varchar(100)
            $table->timestamps();

            // 主キーをauthor_idに設定
            $table->primary('author_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('author_details');
    }
};
