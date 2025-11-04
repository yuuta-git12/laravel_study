<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Book;

class BookController extends Controller
{
    //
    public function index(): Collection
    {
        // 書籍テーブルのレコードを全件取得
        $books = Book::all();

        // 書籍一覧をレスポンスとして返す
        return $books;
    }

    public function show(string $id): Book
    {
        // 書籍を一件取得
        $book = Book::findOrFail($id);

        // 書籍をレスポンスとして返す
        return $book;
    }
}
