<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
{
    /**
     * APIレスポンスの形式を定義する
     * type・id・body・urlをJSON形式で返す
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'type' => 'message',       // リソース種別
            'id'   => $this->id,       // メッセージID
            'body' => $this->body,     // メッセージ本文
            'url'  => url('/messages/' . $this->id), // リソースURL
        ];
    }
}
