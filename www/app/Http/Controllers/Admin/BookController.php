<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookPostRequest;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\View;
use App\Models\Book;
use App\Models\Category;

/**
 * 書籍管理コントローラー
 *
 * 管理者向けの書籍CRUD操作を提供するコントローラー
 */
class BookController extends Controller
{
    /**
     * 書籍一覧を取得する
     *
     * @return Collection<int, Book> 書籍コレクション
     */
    public function index(): Collection
    {
        // 書籍テーブルのレコードを全件取得
        $books = Book::all();

        // 書籍一覧をレスポンスとして返す
        return $books;
    }

    /**
     * 指定されたIDの書籍を取得する
     *
     * @param string $id 書籍ID
     * @return Book 書籍モデル
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException 書籍が見つからない場合
     */
    public function show(string $id): Book
    {
        // 書籍を一件取得
        $book = Book::findOrFail($id);

        // 書籍をレスポンスとして返す
        return $book;
    }

    /**
     * 新しい書籍を登録する
     *
     * @param BookPostRequest $request バリデーション済みリクエスト
     * @return Book 作成された書籍モデル
     */
    public function store(BookPostRequest $request): Book
    {
        // 新しい書籍インスタンスを作成
        $book = new Book();

        // リクエストデータを設定
        $book->category_id = $request->category_id;
        $book->title = $request->title;
        $book->price = $request->price;

        // データベースに保存
        $book->save();

        return $book;
    }

    public function create(): View {
        $categories = Category::all();

        // ビューオブジェクトを返す
        return view('admin/book/create', ['categories' => $categories]);
    }
}
