<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * データベースの初期データを投入する
     *
     * シーダーの実行順序は外部キー制約に従う必要がある
     * admins → authors → books（admin_id・category_idを参照）→ author_book（中間テーブル）
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        // CategoriesTableSeederを呼び出す
        // $this->call(CategoriesTableSeeder::class);
        // AuthorsTableSeederを呼び出す
        // $this->call(AuthorsTableSeeder::class);
        // BooksTableSeederを呼び出す
        // $this->call(BooksTableSeeder::class);

        // 複数のシーダーを配列で渡して一括呼び出しする
        // call()は配列を受け取ると、順番に各シーダーを実行する
        $this->call([
            AdminsTableSeeder::class,     // 管理者データを投入（booksテーブルのadmin_idが参照する）
            AuthorsTableSeeder::class,    // 著者データを投入
            BooksTableSeeder::class,      // 書籍データを投入（admins・categoriesテーブルに依存）
            AuthorBookTableSeeder::class, // 書籍と著者の中間テーブルにデータを投入
        ]);
    }
}
