<?php

namespace Tests\Feature\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Admin;
use App\Models\Category;
use App\Models\Book;
use App\Models\Author;

class BookUpdatedTest extends TestCase
{
    use RefreshDatabase;

    private $admin;
    private $categories;
    private $book;
    private $authors;

    public function setUp(): void
    {
        parent::setUp();

        // ログイン用ユーザーを作成
        $this->admin = Admin::factory()->create([
            'login_id' => 'test_user',
            'password' => \Hash::make('pass@12345'),
        ]);

        // カテゴリを３件作成
        $this->categories = Category::factory(3)->create();

        // 更新対象の書籍1件作成
        $this->book = Book::factory()->create([
            'title' => 'Laravel Book',
            'admin_id' => $this->admin->id,
            'category_id' => $this->categories[1]->id,
        ]);

        $this->book = Book::factory()->create([
            'title' => 'Laravel Book',
            'admin_id' => $this->admin->id,
            'category_id' => $this->categories[2]->id,
        ]);

        // 著者4件作成
        $this->authors = Author::factory(4)->create();

        // 著者4件中2件を書籍に関連づけ
        $this->book->authors()->attach([
            $this->authors[0]->id,
            $this->authors[2]->id,
        ]);
    }

    /** @test */
    public function 画面のアクセス制御(): void
    {
        $url = route('book.edit', $this->book);

        // 未認証の場合、更新画面にアクセス不可
        $this->get($url)
            ->assertRedirect(route('admin.create'));

        // 書籍の作成者とは異なるユーザーで認証
        $other = Admin::factory()->create();
        $this->actingAs($other, 'admin');

        // 書籍の作成者ではない場合、更新画面にアクセス不可
        $this->get($url)
            ->assertForbidden();    // 403

        // 作成者で認証
        $this->actingAs($this->admin, 'admin');

        // 書籍の作成者の場合、更新画面にアクセス可
        $this->get($url)
            ->assertOk();
    }

    /** @test */
    public function 更新処理のアクセス制御(): void
    {
        $url = route('book.update', $this->book);

        // 入力データ
        $param = [
            'category_id' => $this->categories[0]->id,
            'title' => 'New Laravel Book',
            'price' => '10000',
            'author_ids' => [
                $this->authors[1]->id,
                $this->authors[2]->id,
            ],
        ];

        // 未認証の場合、更新不可
        $this->put($url, $param)
            ->assertRedirect(route('admin.create'));

        // 書籍の作成者とは異なるユーザーで認証
        $other = Admin::factory()->create();
        $this->actingAs($other, 'admin');

        // 書籍の作成者でない場合、更新不可(403)
        $this->put($url, $param)
            ->assertForbidden();

        // 書籍データが更新されていないことを確認
        $this->assertSame('Laravel Book', $this->book->fresh()->title);

        // 正常処理は更新テストで別途行う
    }

    /** @test */
    public function バリデーション()
    {
        // 作成者で認証
        $this->actingAs($this->admin, 'admin');

        $url = route('book.update', $this->book);

        // リダイレクト先の確認
        $this->from(route('book.edit', $this->book))
            ->put($url, ['category_id' => ''])
            ->assertRedirect(route('book.edit', $this->book));

        // ここ以降バリデーションとメッセージの確認
        // カテゴリIDが空
        $this->put($url, ['category_id' => ''])
            ->assertInvalid(['category_id' => 'カテゴリは必須入力']);

        // カテゴリIDが存在しない値0
        $this->put($url, ['category_id' => '0'])
            ->assertInvalid(['category_id' => '正しい カテゴリ']);

        // カテゴリIDが3つ目のID(正常)
        $this->put($url, ['category_id' => $this->categories[2]->id])
            ->assertValid('category_id');

        // タイトルが空
        $this->put($url, ['title' => ''])
            ->assertInvalid(['title' => 'タイトルは必須入力']);

        // タイトルが1文字(正常)
        $this->put($url, ['title' => 'A'])
            ->assertValid('title');

        // タイトルが100文字（正常)
        $this->put($url, ['title' => str_repeat('A', 100)])
            ->assertValid('title');

        // タイトルが101文字（異常)
        $this->put($url, ['title' => str_repeat('A', 101)])
            ->assertInvalid(['title' => 'タイトル は 100文字以内']);

        // 価格が数値でない(異常)
        $this->put($url, ['price' => 'A'])
            ->assertInvalid(['price' => '価格は数値']);

        // 価格が0(異常)
        $this->put($url, ['price' => '0'])
            ->assertInvalid(['price' => '価格 は 1以上']);

        // 価格が１（正常）
        $this->put($url, ['price' => '1'])->assertValid('price');

        // 価格が999999（正常）
        $this->put($url, ['price' => '999999'])->assertValid('price');

        // 価格が1000000(異常)
        $this->put($url, ['price' => '1000000'])->assertInvalid(['price' => '価格 は 999999以下']);

        // 著者IDha複数なので配列形式で渡す
        // 著者IDが空
        $this->put($url, ['author_ids' => []])
            ->assertInvalid(['author_ids' => '著者は必須入力']);

        // 著者IDが0(著者テーブルに存在しない)
        $this->put($url, ['author_ids' => ['0']])
            ->assertInvalid(['author_ids.0' => '正しい 著者']);

        // 著者IDが3つ目の著者ID(正常)
        $this->put($url, ['author_ids' => [$this->categories[2]->id]])
            ->assertValid('author_ids.0');

    }
}
