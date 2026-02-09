<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookPostRequest;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\Book;
use App\Models\Category;
use Symfony\Component\HttpFoundation\Response;

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
    public function index(): Response
    {
        // 書籍テーブルのレコードを全件取得
        $books = Book::with('category')
                    ->orderBy('category_id')
                    ->orderBy('title')
                    ->get();

        // 書籍一覧をレスポンスとして返す
        return response()
                ->view('admin/book/index',['books' => $books])
                ->header('Content-Type','text/html')
                ->header('Content-Encoding', 'UTF-8');
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
     * @return RedirectResponse 書籍一覧へのリダイレクト
     */
    public function store(BookPostRequest $request): RedirectResponse
    {
        // バリデーション済みデータを取得
        $validated = $request->validated();

        // 新しい書籍を作成して保存
        $book = new Book();
        $book->fill($validated);
        $book->save();

        // 登録完了後にbook.indexにリダイレクトする
        return redirect(route('book.index'))
            ->with('message',$book->title.'を追加しました。');
    }

    /**
     * 書籍登録フォームを表示する
     *
     * @return View 書籍登録フォームのビュー
     */
    public function create(): View {
        $categories = Category::all();

        // ビューオブジェクトを返す(第1引数:ビューファイルのパス、第２引数:ビューに渡したい値(連想配列の形))
        return view('admin/book/create', ['categories' => $categories]);
    }
}
