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

Route::get('/', function () {
    return view('welcome');
});

Route::get('messages',[MessageController::class,'index']);  // GETリクエストの送信先を指定(MessageControllerのindexメソッド)
Route::post('messages',[MessageController::class,'store']); // POSTリクエストの送信先を指定(MessageControllerのstoreメソッド)

// 書籍管理機能のルートを定義
Route::prefix('admin/books')
    ->name('books.')
    ->controller(BookController::class)
    ->group(function(){
    // 書籍一覧ページのルートを定義
    Route::get('','index')->name('index');
    // 書籍詳細ページのルートを定義
    Route::get('{id}','show')->whereNumber('id')->name('show');
});
