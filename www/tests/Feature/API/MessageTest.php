<?php

namespace Tests\Feature\API;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Message;

// MessageControllerのAPIエンドポイントに対するFeatureテスト
class MessageTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function 一覧取得(): void
    {
        // テスト用データを2件作成
        $message1 = Message::create(['body' => 'Hello']);
        $message2 = Message::create(['body' => 'Hi']);

        // GET /api/messages → 200 OK、MessageResourceの形式で返ること
        $this->getJson(route('api.message.index'))
            ->assertOk()
            ->assertJson([
                'data' => [
                    [
                        'type' => 'message',
                        'id' => $message1->id,
                        'body' => $message1->body,
                        'url' => url('/messages/' . $message1->id),
                    ],
                    [
                        'type' => 'message',
                        'id' => $message2->id,
                        'body' => $message2->body,
                        'url' => url('/messages/' . $message2->id),
                    ],
                ]
            ]);
    }

    /** @test */
    public function 一件取得(): void
    {
        $message = Message::create(['body' => 'Hello']);

        // GET /api/messages/{id} → 200 OK、指定したメッセージがMessageResource形式で返ること
        $this->getJson(route('api.message.show', $message))
            ->assertOk()
            ->assertJson([
                'data' => [
                        'type' => 'message',
                        'id' => $message->id,
                        'body' => $message->body,
                        'url' => url('/messages/' . $message->id),
                ]
            ]);
    }

    /** @test */
    public function 登録(): void
    {
        $message = ['body' => 'Bye']; // 登録データ

        // POST /api/messages → 201 Created、登録したデータがレスポンスに含まれること
        $this->postJson(route('api.message.store'), $message)
            ->assertStatus(201)
            ->assertJson($message);

        // assertDatabaseHas: 指定した条件に一致するレコードがDBに存在するか確認する
        // カラムの値が全て一致した場合にtrueを返す
        $this->assertDatabaseHas('messages', $message);
    }

    /** @test */
    public function 削除(): void
    {
        $message = Message::create(['body' => 'Hello']);

        // DELETE /api/messages/{id} → 204 No Content
        $this->deleteJson('api/messages/' . $message->id)
            ->assertStatus(204);

        // assertModelMissing: 対象のモデルがDBから削除されていることを確認
        $this->assertModelMissing($message);
    }
}
