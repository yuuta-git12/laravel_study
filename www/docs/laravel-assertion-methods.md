# Laravel テスト アサーションメソッド一覧

## 1. レスポンスを確認するアサーションメソッド

### ステータスコード

| メソッド | 説明 |
|---|---|
| `assertStatus(int $status)` | 指定したHTTPステータスコードであることを確認 |
| `assertOk()` | ステータスコードが 200 であることを確認 |
| `assertCreated()` | ステータスコードが 201 であることを確認 |
| `assertNoContent()` | ステータスコードが 204 であることを確認 |
| `assertNotFound()` | ステータスコードが 404 であることを確認 |
| `assertForbidden()` | ステータスコードが 403 であることを確認 |
| `assertUnauthorized()` | ステータスコードが 401 であることを確認 |
| `assertUnprocessable()` | ステータスコードが 422 であることを確認 |
| `assertServerError()` | ステータスコードが 500 以上であることを確認 |
| `assertSuccessful()` | ステータスコードが 2xx であることを確認 |
| `assertRedirect(?string $uri)` | リダイレクトレスポンス (302) であることを確認 |
| `assertRedirectToRoute(string $name)` | 指定した名前のルートにリダイレクトすることを確認 |

### ページ・ビュー

| メソッド | 説明 |
|---|---|
| `assertViewIs(string $value)` | 指定したビューが返されることを確認 |
| `assertViewHas(string $key, mixed $value)` | ビューに指定したデータが含まれることを確認 |
| `assertViewMissing(string $key)` | ビューに指定したデータが含まれないことを確認 |
| `assertSee(string $value)` | レスポンスに指定した文字列が含まれることを確認 |
| `assertSeeText(string $value)` | レスポンスのテキストに指定した文字列が含まれることを確認 |
| `assertDontSee(string $value)` | レスポンスに指定した文字列が含まれないことを確認 |
| `assertDontSeeText(string $value)` | レスポンスのテキストに指定した文字列が含まれないことを確認 |

### JSON

| メソッド | 説明 |
|---|---|
| `assertJson(array $data)` | JSONレスポンスに指定したデータが含まれることを確認 |
| `assertJsonPath(string $path, mixed $value)` | 指定したJSONパスに値が存在することを確認 |
| `assertJsonCount(int $count, string $key)` | 指定したキーの配列要素数を確認 |
| `assertJsonMissing(array $data)` | JSONレスポンスに指定したデータが含まれないことを確認 |
| `assertExactJson(array $data)` | JSONレスポンスが指定したデータと完全一致することを確認 |
| `assertJsonStructure(array $structure)` | JSONレスポンスが指定した構造を持つことを確認 |
| `assertJsonValidationErrors(array $errors)` | バリデーションエラーが含まれることを確認 |

### バリデーション

| メソッド | 説明 |
|---|---|
| `assertValid(array $fields)` | 指定したフィールドにバリデーションエラーがないことを確認 |
| `assertInvalid(array $fields)` | 指定したフィールドにバリデーションエラーがあることを確認 |

### セッション・クッキー

| メソッド | 説明 |
|---|---|
| `assertSessionHas(string $key, mixed $value)` | セッションに指定したデータが存在することを確認 |
| `assertSessionMissing(string $key)` | セッションに指定したデータが存在しないことを確認 |
| `assertSessionHasErrors(array $keys)` | セッションにバリデーションエラーが存在することを確認 |
| `assertCookie(string $name, ?string $value)` | クッキーが存在することを確認 |
| `assertCookieMissing(string $name)` | クッキーが存在しないことを確認 |

### 使用例

```php
// ステータスコードとビューの確認
$response = $this->get('/books');
$response->assertStatus(200);
$response->assertViewIs('books.index');
$response->assertViewHas('books');

// バリデーションエラーの確認
$response = $this->post('/books', []);
$response->assertInvalid(['title', 'author_id']);

// リダイレクトの確認
$response = $this->post('/books', $data);
$response->assertRedirect('/books');
```

---

## 2. データベースを確認するアサーションメソッド

### レコード存在確認

| メソッド | 説明 |
|---|---|
| `assertDatabaseHas(string $table, array $data)` | テーブルに指定したデータが存在することを確認 |
| `assertDatabaseMissing(string $table, array $data)` | テーブルに指定したデータが存在しないことを確認 |
| `assertDatabaseCount(string $table, int $count)` | テーブルのレコード数を確認 |
| `assertDatabaseEmpty(string $table)` | テーブルが空であることを確認 |

### ソフトデリート

| メソッド | 説明 |
|---|---|
| `assertSoftDeleted(string $table, array $data)` | レコードがソフトデリートされていることを確認 |
| `assertNotSoftDeleted(string $table, array $data)` | レコードがソフトデリートされていないことを確認 |

### モデルの存在確認

| メソッド | 説明 |
|---|---|
| `assertModelExists(Model $model)` | 指定したモデルがDBに存在することを確認 |
| `assertModelMissing(Model $model)` | 指定したモデルがDBに存在しないことを確認 |

### 使用例

```php
// レコードが作成されたことを確認
$this->post('/books', ['title' => 'Laravel入門', 'author_id' => 1]);
$this->assertDatabaseHas('books', ['title' => 'Laravel入門']);

// レコードが削除されたことを確認
$book = Book::factory()->create();
$this->delete("/books/{$book->id}");
$this->assertDatabaseMissing('books', ['id' => $book->id]);

// レコード数の確認
Book::factory()->count(3)->create();
$this->assertDatabaseCount('books', 3);

// モデルの存在確認
$book = Book::factory()->create();
$this->assertModelExists($book);
$this->delete("/books/{$book->id}");
$this->assertModelMissing($book);
```

---

## 3. オブジェクトの状態を確認するアサーションメソッド

### PHPUnit 標準メソッド

| メソッド | 説明 |
|---|---|
| `assertEquals(mixed $expected, mixed $actual)` | 値が等しいことを確認（型を考慮しない） |
| `assertSame(mixed $expected, mixed $actual)` | 値と型が完全に等しいことを確認 |
| `assertNotEquals(mixed $expected, mixed $actual)` | 値が等しくないことを確認 |
| `assertNotSame(mixed $expected, mixed $actual)` | 値が完全一致しないことを確認 |
| `assertTrue(mixed $condition)` | 値が true であることを確認 |
| `assertFalse(mixed $condition)` | 値が false であることを確認 |
| `assertNull(mixed $actual)` | 値が null であることを確認 |
| `assertNotNull(mixed $actual)` | 値が null でないことを確認 |
| `assertEmpty(mixed $actual)` | 値が空であることを確認 |
| `assertNotEmpty(mixed $actual)` | 値が空でないことを確認 |
| `assertCount(int $expected, array $array)` | 配列の要素数を確認 |
| `assertInstanceOf(string $class, mixed $actual)` | 指定したクラスのインスタンスであることを確認 |
| `assertContains(mixed $needle, array $haystack)` | 配列に指定した値が含まれることを確認 |
| `assertArrayHasKey(string $key, array $array)` | 配列に指定したキーが存在することを確認 |
| `assertStringContainsString(string $needle, string $haystack)` | 文字列に指定した文字列が含まれることを確認 |
| `assertMatchesRegularExpression(string $pattern, string $string)` | 文字列が正規表現にマッチすることを確認 |

### 認証系

| メソッド | 説明 |
|---|---|
| `assertAuthenticated(string $guard)` | 指定したガードで認証されていることを確認 |
| `assertGuest(string $guard)` | 指定したガードで未認証であることを確認 |
| `assertAuthenticatedAs(Model $user, string $guard)` | 指定したユーザーで認証されていることを確認 |

### 使用例

```php
// 値の比較
$book = Book::find(1);
$this->assertEquals('Laravel入門', $book->title);
$this->assertSame(1, $book->author_id); // 型も確認
$this->assertNotNull($book->published_at);

// 配列・コレクションの確認
$books = Book::all();
$this->assertCount(3, $books);
$this->assertNotEmpty($books);

// インスタンスの確認
$book = Book::factory()->make();
$this->assertInstanceOf(Book::class, $book);

// 認証の確認（admin ガードの場合）
$admin = Admin::factory()->create();
$this->actingAs($admin, 'admin')->get('/admin/dashboard');
$this->assertAuthenticatedAs($admin, 'admin');

// ゲストの確認
$this->post('/admin/logout');
$this->assertGuest('admin');
```

---

## まとめ

| カテゴリ | 主な用途 |
|---|---|
| レスポンス確認 | HTTPステータス、ビュー、JSON、バリデーションエラーの検証 |
| データベース確認 | CRUD操作後のDB状態を検証 |
| オブジェクト状態確認 | 値・型・認証状態・コレクションの内容を検証 |
