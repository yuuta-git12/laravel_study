<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookPostRequest;
use App\Http\Requests\BookPutRequest;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;  // DBファサード（トランザクション処理で使用）
use Illuminate\View\View;
use App\Models\Book;
use App\Models\Category;
use App\Models\Author;  // Authorモデルの読み込み
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
     * 書籍詳細を表示する
     *
     * 暗黙のルートモデルバインディングにより、URLパラメータ{book}から
     * 対応するBookモデルが自動的に取得・注入される。
     * 該当する書籍が存在しない場合は404エラーが自動的に返される。
     *
     * @param Book $book ルートモデルバインディングで解決された書籍モデル
     * @return View 書籍詳細ビュー
     */
    public function show(Book $book): View
    {
        // compact()：変数名の文字列から連想配列を作成（['book' => $book]と同等）
        return view('admin/book/show', compact('book'));
    }

    /**
     * 新しい書籍を登録する
     *
     * @param BookPostRequest $request バリデーション済みリクエスト
     * @return RedirectResponse 書籍一覧へのリダイレクト
     */
    public function store(BookPostRequest $request): RedirectResponse
    {
        // 新しい書籍を作成して保存
        $book = new Book();

        // リクエストオブジェクトからパラメータを取得してBookモデルの各カラムにセット
        // ※リクエストパラメータはフォームのname属性で定義され、BookPostRequestでバリデーション済み
        $book->category_id = $request->category_id;
        $book->title = $request->title;
        $book->price = $request->price;

        // DB::transaction()でトランザクション処理を実行
        // 書籍の保存と著者の紐付けを一括で行い、どちらかが失敗した場合は全てロールバックされる
        // use()句でクロージャ内で使用する外部変数を渡す
        DB::transaction(function() use($book, $request){

            // booksテーブルに保存（INSERT）
            $book->save();

            // 中間テーブル(author_book)にレコードを登録
            // attach()：多対多リレーションの中間テーブルにレコードを追加するメソッド
            $book->authors()->attach($request->author_ids);
        });

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

        // ビューに表示するカテゴリ一覧の全件取得
        $categories = Category::all();

        // 著者一覧の全件取得
        $authors = Author::all();

        // ビューオブジェクトを返す(第1引数:ビューファイルのパス、第２引数:ビューに渡したい値(連想配列の形))
        return view('admin/book/create', compact('categories','authors'));
    }

    /**
     * 書籍編集フォームを表示する
     *
     * @param Book $book ルートモデルバインディングで解決された書籍モデル
     * @return View 書籍編集フォームのビュー
     */
    public function edit(Book $book): View
    {
        // ビューに表示するカテゴリ一覧の全件取得
        $categories = Category::all();

        // 著者一覧の全件取得
        $authors = Author::all();

        // 書籍に紐づく著者IDの一覧取得
        // pluck('id')：著者モデルのコレクションからIDカラムのみを抽出
        // all()：コレクションを通常の配列に変換（ビュー側のin_array()で使用するため）
        $authorIds = $book->authors()->pluck('id')->all();

        // ビューオブジェクトを返す（書籍データ、カテゴリ一覧、著者一覧、選択済み著者IDを渡す）
        return view('admin/book/edit', compact('book', 'categories', 'authors', 'authorIds'));
    }

    /**
     * 書籍更新処理
     *
     * @param BookPutRequest $request バリデーション済みのリクエスト
     * @param Book $book ルートモデルバインディングで解決された書籍モデル
     * @return RedirectResponse 書籍一覧ページへのリダイレクト
     */
    public function update(BookPutRequest $request, Book $book):RedirectResponse{

        // リクエストオブジェクトからパラメータを取得してBookモデルの各カラムにセット
        $book->category_id = $request->category_id;
        $book->title = $request->title;
        $book->price = $request->price;

        // DB::transaction()でトランザクション処理を実行
        // 書籍の更新と著者の紐付け更新を一括で行い、どちらかが失敗した場合は全てロールバックされる
        DB::transaction(function() use($book, $request) {
            // booksテーブルを更新（UPDATE）
            $book->update();

            // 中間テーブル(author_book)のレコードを更新
            // sync()：渡されたIDの配列と中間テーブルの状態を同期する（不要なレコードは削除、新規は追加）
            $book->authors()->sync($request->author_ids);
        });

        // 更新完了後にbook.indexにリダイレクトし、フラッシュメッセージを表示
        return redirect(route('book.index'))->with('message', $book->title.'を変更しました。');
    }

}
