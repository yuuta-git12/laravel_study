<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Author;
use App\Models\AuthorDetail;

class AuthorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // AuthorFactoryを呼び出す　
        // Author::factory(5)->create(); //ファイルで定義された内容に基づいて5件のレコードを登録
        // AuthorDetailFactoryを呼び出す
        AuthorDetail::factory(5)->create(); //ファイルで定義された内容に基づいて5件のレコードを登録
    }
}
