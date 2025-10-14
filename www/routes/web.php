<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MessageController;

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
