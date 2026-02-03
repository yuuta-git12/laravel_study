## 書籍登録機能の処理フロー

### 1. `GET /admin/books/create` - 登録フォーム表示

```
ブラウザ → Route → BookController::create() → View
```

| 順序 | 処理内容 |
|------|----------|
| 1 | ユーザーが `/admin/books/create` にアクセス |
| 2 | `web.php` のルート定義でマッチング |
| 3 | `BookController::create()` が呼び出される |
| 4 | `Category::all()` で全カテゴリを取得 |
| 5 | `admin/book/create.blade.php` にカテゴリデータを渡してレンダリング |
| 6 | HTMLフォームがブラウザに返される |

#### 関連ファイル
- `routes/web.php:57` - ルート定義
- `app/Http/Controllers/admin/BookController.php:71-76` - createメソッド
- `resources/views/admin/book/create.blade.php` - ビューテンプレート

---

### 2. `POST /admin/books` - 書籍登録処理

```
ブラウザ → Route → BookPostRequest(バリデーション) → BookController::store() → DB保存
                         ↓ (失敗時)
                    リダイレクト（エラー表示）
```

| 順序 | 処理内容 |
|------|----------|
| 1 | ユーザーがフォームを送信（POST） |
| 2 | `web.php` のルート定義でマッチング |
| 3 | **BookPostRequest による自動バリデーション** |
| 3-1 | `authorize()` で認可チェック（現在は常にtrue） |
| 3-2 | `rules()` でバリデーション実行 |
| 4 | **バリデーション失敗時**: 元のフォームにリダイレクト＋エラーメッセージ |
| 5 | **バリデーション成功時**: `BookController::store()` が呼び出される |
| 6 | 新しい `Book` インスタンスを作成 |
| 7 | リクエストデータ（category_id, title, price）をセット |
| 8 | `$book->save()` でDBに保存 |
| 9 | 作成された `Book` オブジェクトをレスポンスとして返す |

#### バリデーションルール
| フィールド | ルール |
|-----------|--------|
| `category_id` | 必須、categoriesテーブルに存在するID |
| `title` | 必須、booksテーブルでユニーク、最大100文字 |
| `price` | 数値、1〜999999の範囲 |

#### 関連ファイル
- `routes/web.php:58` - ルート定義
- `app/Http/Requests/BookPostRequest.php` - バリデーション
- `app/Http/Controllers/admin/BookController.php:55-69` - storeメソッド

---

### シーケンス図

```
┌────────┐     ┌─────────┐     ┌─────────────────┐     ┌──────────────┐     ┌────┐
│ Browser│     │ Route   │     │ BookPostRequest │     │BookController│     │ DB │
└───┬────┘     └────┬────┘     └────────┬────────┘     └──────┬───────┘     └─┬──┘
    │               │                   │                     │               │
    │ GET /create   │                   │                     │               │
    │──────────────>│                   │                     │               │
    │               │──────────────────────────────────────-->│               │
    │               │                   │                     │ Category::all │
    │               │                   │                     │──────────────>│
    │               │                   │                     │<──────────────│
    │<─────────────────────────────────────────── View (HTML) │               │
    │               │                   │                     │               │
    │ POST /store   │                   │                     │               │
    │──────────────>│                   │                     │               │
    │ authorize()   │                   │                     │               │
    │               │──────────────────>│                     │               │
    │ rules()       │                   │                     │               │
    │               │──────────────────>│                     │               │
    │               │                   │                     │               │
    │  [バリデーション失敗] ←───────────│                     │               │
    │               │                   │                     │               │
    │               │   [成功時]        │                     │               │
    │               │──────────────────────────────────────-->│               │
    │               │                   │                     │ Book::save()  │
    │               │                   │                     │──────────────>│
    │               │                   │                     │<──────────────│
    │<─────────────────────────────────────────── Book (JSON) │               │
```
