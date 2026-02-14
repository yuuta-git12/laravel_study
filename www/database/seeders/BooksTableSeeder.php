<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BooksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // Book::factory(3)->create(); //ファイルで定義された内容に基づいて3件のレコードを登録

        // 自身で指定した値をレコードに上書きする
        $categories = [
            // ファクトリで生成されるタイトルを上書きする
            Category::factory()->create(['title' => 'programming']),
            Category::factory()->create(['title' => 'disign']),
            Category::factory()->create(['title' => 'management']),
        ];

        foreach($categories as $category){
            // $category1件につき、2件の書籍を登録する
            // Category::factory()で生成されるカテゴリIDを上書きする
            Book::factory(2)
                ->create(['category_id' => $category->id]);
        }

    }
}
