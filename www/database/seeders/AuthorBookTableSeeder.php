<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Book;
use App\Models\Author;

class AuthorBookTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //  中間テーブルauthor_bookへのテストデータ登録のシーダー処理
        $books = Book::all();
        $authors = Author::all();

        foreach($books as $book){
            // authorsから2件レコードをランダムに取得
            // 取得したレコードからidだけを抽出
            $authorIds = $authors->random(2)->pluck('id')->all();

            // 抜き出した、id配列を$bookに関連づける
            $book->authors()->attach($authorIds);
        }
    }
}
