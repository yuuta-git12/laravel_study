<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\MessageResource;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Models\Message;

class MessageController extends Controller
{
    // Message一覧をMessageResourceコレクションとして返す
    public function index(): AnonymousResourceCollection
    {
        $messages = Message::all();

        // MessageResource::collection()でコレクション全体をJSON整形して返す
        return MessageResource::collection($messages);
    }

    // 指定したMessageを1件MessageResourceとして返す
    public function show(Message $message): MessageResource
    {
        return new MessageResource($message);
    }

    // Messageを新規登録し、HTTPステータスコード201(Created)で返す
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $message = new Message();
        $message->body = $request->body;
        $message->save();

        return response()->json($message, 201);
    }

    // Messageを削除し、HTTPステータスコード204(コンテンツなし)を返す
    public function destroy(Message $message): Response
    {
        $message->delete();

        return response()->noContent();
    }
}
