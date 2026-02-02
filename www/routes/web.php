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
Route::prefix('admin/books')
    ->name('books.')
    ->controller(BookController::class)
    ->group(function () {
        // GET /admin/books - 書籍一覧ページ（ルート名: books.index）
        Route::get('', 'index')->name('index');
        // GET /admin/books/{id} - 書籍詳細ページ（ルート名: books.show）
        // whereNumber('id'): IDは数値のみ許可
        Route::get('{id}', 'show')->whereNumber('id')->name('show');
        Route::get('create', 'create')->name('create');
        Route::post('', 'store')->name('store');
    });
