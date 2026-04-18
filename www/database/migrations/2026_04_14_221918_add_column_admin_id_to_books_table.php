<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * booksテーブルにadmin_idカラムを追加するマイグレーション
 *
 * 書籍の登録者（管理者）を記録するため、adminsテーブルへの外部キーを追加する
 */
return new class extends Migration
{
    /**
     * マイグレーションを実行する（カラム追加）
     */
    public function up(): void
    {
        Schema::table('books', function (Blueprint $table) {
            // admin_idカラムを追加し、外部キー制約を設定　制約名はbooks_admin_id_foreign
            $table->foreignId('admin_id')->constrained();
        });
    }

    /**
     * マイグレーションをロールバックする（カラム削除）
     *
     * 外部キー制約を先に削除してからカラムを削除する必要がある
     */
    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            // 外部キー制約を削除し、admin_idカラムを削除
            $table->dropForeign('books_admin_id_foreign');  // 引数の外部キー制約を削除
            $table->dropColumn('admin_id'); // admin_idカラムを削除
        });
    }
};
