<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\Message;
use Illuminate\Support\Facades\DB;

/**
 * メッセージの一覧表示・作成・削除を管理するコントローラー
 */
class MessageController extends Controller
{
    /**
     * メッセージ一覧を表示する
     */
    public function index(): View
    {
        // メッセージテーブルのレコードを全件取得
        $messages = Message::all();
        // messagesというキーで、ビューへ渡す
        return view('messages/index',['messages' => $messages]);
    }

    /**
     * 新しいメッセージを保存する
     */
    public function store(Request $request): RedirectResponse
    {
        // リクエストからボディを取得し、保存
        $message = new Message(); // メッセージモデルのインスタンスを作成
        $message->body = $request->body; // リクエストからボディを取得し、保存
        $message->save();   // 保存

        // リダイレクト
        return redirect('/messages');
    }

    /**
     * 指定IDのメッセージを削除する
     *
     * @param string $id 削除対象のメッセージID
     */
    public function destroy(String $id): RedirectResponse
    {
        // 削除処理
        DB::delete('delete from messages where id = ?',[$id]);

        // リダイレクト
        return redirect('/messages');
    }
}
