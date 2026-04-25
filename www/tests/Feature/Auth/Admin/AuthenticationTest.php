<?php

namespace Tests\Feature\Auth\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Admin;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    private $admin;

    public function setUp(): void
    {
        // 親のsetUpメソッド呼び出し（必須）
        parent::setUp();

        // ログインテスト用のユーザー作成
        $this->admin = Admin::factory()->create([
            'login_id' => 'test_id',
            'password' => \Hash::make('pass@12345'),
        ]);
    }

    /** @test */
    public function ログイン画面の表示(): void
    {
        // 200(OK)が返る
        $this->get(route('admin.create'))->assertOk();
    }

    /** @test */
    public function ログイン成功(): void
    {
        //2. ログイン成功後、書籍一覧にリダイレクトする
        $this->post(route('admin.store'),[
            'login_id' => 'test_id',
            'password' => 'pass@12345',
        ])->assertRedirect(route('book.index'));

        //3.認証されている
        $this->assertAuthenticatedAs($this->admin, 'admin');
    }

    /** @test */
    public function ログイン失敗(): void
    {
        // IDが一致しない場合
        // 送信元にリダイレクトするためfromを使用
        $this->from(route('admin.store'))
            ->post(route('admin.store'),[
                'login_id' => 'error_id',
                'password' => 'pass@12345',
            ])
            ->assertRedirect(route('admin.create'))
            ->assertInvalid(['login_id' => 'Eメールとパスワードの組み合わせが一致しません']);   // auth.phpで定義したメッセージ

        // パスワードが一致しない場合
        $this->from(route('admin.store'))
                ->post(route('admin.store'),[
                'login_id' => 'test_id',
                'password' => 'password@12',
            ])
            ->assertRedirect(route('admin.create'))
            ->assertInvalid(['login_id' => 'Eメールとパスワードの組み合わせが一致しません']);   // auth.phpで定義したメッセージ

        // 認証されていない
        $this->assertGuest('admin');
    }

    /** @test */
    public function バリデーション(): void
    {
        $url = route('admin.store');

        // リダイレクト
        $this->from(route('admin.create'))
            ->post($url,['login_id' => ''])
            ->assertRedirect(route('admin.create'));

        // ID未入力
        $this->post($url, ['login_id' => ''])
            ->assertInvalid(['login_id' => 'login idは必須']);

        // ID入力
        $this->post($url, ['login_id' => 'a'])
            ->assertValid('login_id');

        // パスワード未入力
        $this->post($url, ['password' => ''])
            ->assertInvalid(['password' => 'passwordは必須']);

        // パスワード
        $this->post($url, ['password' => 'pass@12345'])
            ->assertValid('password');

    }

}
