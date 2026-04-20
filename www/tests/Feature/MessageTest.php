<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Message;

class MessageTest extends TestCase
{
    // RefreshDatabase: テストのたびにマイグレーションを再実行してDBをクリーンな状態に保つ
    use RefreshDatabase;

    /** @test */
    public function メッセージ一覧の表示(): void
    {
        // Arrange（準備）: テスト用メッセージを2件作成
        // $fillable に 'body' を設定しているため create() で一括代入が可能
        Message::create(['body' => 'Hello World']);
        Message::create(['body' => 'Hello Laravel']);

        // Act & Assert（実行と検証）
        // GET /messages が 200 を返し、作成した順にメッセージが表示されることを確認
        // assertSeeInOrder: 表示順序まで検証する（orderBy('id') と対応）
        $this->get('messages')
            ->assertOk()
            ->assertSeeInOrder([
                'Hello World',
                'Hello Laravel',
            ]);
    }
}
