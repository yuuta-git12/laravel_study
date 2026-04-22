# 学習記録のメモ

## 2026-04-21 今日やったこと

### 自動テストの追加（feature0010/AutoTests）

`MessageTest` と `AuthenticationTest`（Admin用）の Feature テストを作成した。

---

### AuthenticationTest（`tests/Feature/Auth/Admin/AuthenticationTest.php`）

Admin のログイン画面表示・ログイン成功を検証するテスト。

#### 使用クラス

| クラス | 名前空間 | 役割 |
|---|---|---|
| `TestCase` | `Tests\TestCase` | Laravel テストの基底クラス。PHPUnit の TestCase を拡張し、Laravelアプリケーションをブート |
| `RefreshDatabase` | `Illuminate\Foundation\Testing` | trait。テスト実行ごとにマイグレーションを再実行しDBをリセットする |
| `WithFaker` | `Illuminate\Foundation\Testing` | trait。Fakerによるフェイクデータ生成機能を追加（このファイルでは import のみ） |
| `Admin` | `App\Models\Admin` | 管理者モデル。`Authenticatable` を継承し、マルチ認証ガード `admin` で使用 |
| `Authenticatable` | `Illuminate\Foundation\Auth` | 認証機能を提供するベースクラス。`login_id`/`password` での認証が可能になる |
| `AdminFactory` | `Database\Factories` | `Admin` モデルのファクトリ。`fake()` でダミーデータを生成 |

#### 使用メソッド

| メソッド | 説明 |
|---|---|
| `$this->get(string $uri)` | テスト用GETリクエストを送信。戻り値は `TestResponse` |
| `->assertOk()` | HTTPステータスコードが `200` であることを検証 |
| `Admin::factory()->create(array $attributes)` | DBにモデルを1件生成・保存。引数で属性を上書き可能 |
| `\Hash::make(string $value)` | bcryptなどでパスワードをハッシュ化（`Illuminate\Support\Facades\Hash`） |
| `$this->post(string $uri, array $data)` | テスト用POSTリクエストを送信 |
| `->assertRedirect(string $uri)` | レスポンスが指定URIへのリダイレクトであることを検証 |
| `$this->assertAuthenticatedAs($user, string $guard)` | 指定ガードで指定ユーザーが認証済みであることを検証 |
| `route(string $name)` | ルート名からURLを生成するヘルパ関数 |
| `fake()` | `Faker\Generator` インスタンスを返すグローバルヘルパ（ファクトリ内で使用） |

#### テストメソッドの内容

```php
// ログイン画面の表示
$this->get(route('admin.create'))->assertOk();
// → GET /admin/login が 200 を返すことを確認

// ログイン成功
$admin = Admin::factory()->create(['login_id' => 'test_id', 'password' => Hash::make('password')]);
$this->post(route('admin.store'), [...])
     ->assertRedirect(route('book.index'));  // ログイン後は書籍一覧へリダイレクト
$this->assertAuthenticatedAs($admin, 'admin'); // adminガードで認証済みか確認
```

---

### MessageTest（`tests/Feature/MessageTest.php`）

メッセージ一覧の表示順序を検証するテスト。

| メソッド | 説明 |
|---|---|
| `Message::create(array $attributes)` | DBにレコードを直接作成（`$fillable` に `body` が必要） |
| `->assertSeeInOrder(array $values)` | レスポンスHTML内に指定した値が **その順番で** 含まれることを検証 |

---

## 文字コード
- BOM(Byte Order Mark)：Unicode形式テキストの先頭に付与される数バイトのデータ
- BOM利用することで、そのテキストがUnicodeで記述されていること、その種類を識別できる。
- PHPではBOM付きのファイルを正しく処理できない場合がある。拡張子がphpのファイルを保存する場合には、必ずBOMなしのUTF-8として保存する。