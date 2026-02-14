<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\Message;

class MessageController extends Controller
{
    //
    public function index(): View
    {
        // メッセージテーブルのレコードを全件取得
        $messages = Message::all();
        // messagesというキーで、ビューへ渡す
        return view('messages/index',['messages' => $messages]);
    }

    public function store(Request $request): RedirectResponse
    {
        // リクエストからボディを取得し、保存
        $message = new Message(); // メッセージモデルのインスタンスを作成
        $message->body = $request->body; // リクエストからボディを取得し、保存
        $message->save();   // 保存

        // リダイレクト
        return redirect('/messages');
    }
}
