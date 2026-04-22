<?php

namespace Tests\Feature\Auth\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Admin;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function ログイン画面の表示(): void
    {
        // 200(OK)が返る
        $this->get(route('admin.create'))->assertOk();
    }

    /** @test */
    public function ログイン成功(): void
    {
        // 1.ログインようユーザー作成
        $admin_user = Admin::factory()->create([
            'login_id' => 'test_id',
            'password' => \Hash::make('password'),
        ]);

        //2. ログイン成功後、書籍一覧にリダイレクトする
        $this->post(route('admin.store'),[
            'login_id' => 'test_id',
            'password' => 'password',
        ])->assertRedirect(route('book.index'));

        //3.認証されている
        $this->assertAuthenticatedAs($admin_user, 'admin');
    }

    /** @test */
    public function ログイン失敗(): void
    {
        // 事前情報としてログイン用ユーザー作成
        $admin_user = Admin::factory()->create([
            'login_id' => 'test_id',
            'password' => \Hash::make('password'),
        ]);

        // IDが一致しない場合
        // 送信元にリダイレクトするためfromを使用
        $this->from(route('admin.store'))
            ->post(route('admin.store'),[
                'login_id' => 'error_id',
                'password' => 'password',
            ])
            ->assertRedirect(route('admin.create'))
            ->assertInvalid(['login_id' => 'Eメールとパスワードの組み合わせが一致しません']);   // auth.phpで定義したメッセージ

        // パスワードが一致しない場合
        $this->from(route('admin.store'))
                ->post(route('admin.store'),[
                'login_id' => 'test_id',
                'password' => 'error_password',
            ])
            ->assertRedirect(route('admin.create'))
            ->assertInvalid(['login_id' => 'Eメールとパスワードの組み合わせが一致しません']);   // auth.phpで定義したメッセージ

        // 認証されていない
        $this->assertGuest('admin');
    }
}
