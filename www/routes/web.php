<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\admin\BookController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/*
|--------------------------------------------------------------------------
| トップページ
|--------------------------------------------------------------------------
| URL: /
| メソッド: GET
| 説明: Laravelのウェルカムページを表示
*/
Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| メッセージ機能
|--------------------------------------------------------------------------
*/
// GET /messages - メッセージ一覧を取得
Route::get('messages', [MessageController::class, 'index']);
// POST /messages - 新しいメッセージを作成
Route::post('messages', [MessageController::class, 'store']);

/*
|--------------------------------------------------------------------------
| 管理者向け書籍管理機能
|--------------------------------------------------------------------------
| プレフィックス: /admin/books
| ルート名プレフィックス: books.
| コントローラー: BookController
*/
Route::prefix('admin/book')
    ->name('book.')
    ->controller(BookController::class)
    ->group(function () {
        // GET /admin/book - 書籍一覧ページ（ルート名: book.index）
        Route::get('', 'index')->name('index');
        // GET /admin/book/{book} - 書籍詳細ページ（ルート名: book.show）
        // {book}はルートモデルバインディングのパラメータ名（Bookモデルに対応）
        // whereNumber('book'): パラメータは数値のみ許可
        Route::get('{book}', 'show')->whereNumber('book')->name('show');
        // GET /admin/book/create - 書籍登録フォーム表示（ルート名: book.create）
        Route::get('create', 'create')->name('create');
        // POST /admin/book - 書籍登録処理（ルート名: book.store）
        Route::post('', 'store')->name('store');
    });
