# 書籍詳細画面（show）フローチャート

index画面から書籍タイトルリンクをクリックし、showメソッドで詳細画面が表示されるまでの流れ。

## フロー概要

```
[ブラウザ] 書籍一覧画面（index.blade.php）
    │
    │ ユーザーが書籍タイトルのリンクをクリック
    │ （book-table.blade.php内の <a href="{{ route('book.show', $book) }}">）
    │
    │ route()ヘルパーがBookモデルのIDを展開し、URLを生成
    │ 例: /admin/book/3
    │
    ▼
[HTTPリクエスト] GET /admin/book/{book}
    │
    ▼
[ルーティング] web.php
    │
    │ Route::get('{book}', 'show')->whereNumber('book')->name('show')
    │
    │ 1. URLパターン /admin/book/{book} にマッチ
    │ 2. whereNumber('book') で数値パラメータであることを検証
    │ 3. BookController の show メソッドにディスパッチ
    │
    ▼
[ルートモデルバインディング] Laravel フレームワーク（暗黙的解決）
    │
    │ URLパラメータ名 {book} とメソッド引数の型ヒント Book $book を照合し、
    │ Book::findOrFail($bookId) を自動実行
    │
    ├── 該当レコードが存在する場合 → Book モデルインスタンスを生成
    │
    └── 該当レコードが存在しない場合 → 404 Not Found を自動返却
    │
    ▼
[コントローラー] BookController::show(Book $book)
    │
    │ 1. 引数 $book にはルートモデルバインディングで解決済みの Book モデルが注入される
    │ 2. compact('book') で連想配列 ['book' => $book] を作成
    │ 3. view('admin/book/show', compact('book')) でビューを返却
    │
    ▼
[ビュー] admin/book/show.blade.php
    │
    │ 1. <x-layouts.book-manager> で共通レイアウトを適用
    │ 2. $book のプロパティを表示
    │    - $book->id（書籍ID）
    │    - $book->category->title（カテゴリ名 ※リレーション経由）
    │    - $book->title（書籍タイトル）
    │    - $book->authors（著者一覧 ※多対多リレーション経由）
    │ 3. route('book.index') で一覧画面への戻るリンクを表示
    │
    ▼
[ブラウザ] 書籍詳細画面が表示される
```

## 関連ファイル一覧

| ファイル | 役割 |
|---|---|
| `routes/web.php` | ルーティング定義（`{book}`パラメータとルートモデルバインディング） |
| `app/Http/Controllers/Admin/BookController.php` | `show`メソッドでビューを返却 |
| `resources/views/admin/book/show.blade.php` | 書籍詳細画面のビュー |
| `resources/views/components/book-table.blade.php` | 一覧画面内のテーブル（詳細へのリンク元） |
| `resources/views/components/layouts/book-manager.blade.php` | 共通レイアウトコンポーネント |
| `app/Models/Book.php` | 書籍モデル（ルートモデルバインディングの対象） |

## ポイント：暗黙のルートモデルバインディング

従来の方法ではコントローラー内で `Book::findOrFail($id)` を明示的に呼び出す必要があったが、
ルートモデルバインディングを使うことで以下のメリットがある。

1. **ルートパラメータ名** `{book}` と **メソッド引数の型ヒント** `Book $book` が一致すると、Laravelが自動的にモデルを解決する
2. レコードが見つからない場合の **404処理が自動化** される
3. コントローラーのコードが **簡潔** になる

```php
// 従来の方法
public function show(string $id): View
{
    $book = Book::findOrFail($id);
    return view('admin/book/show', compact('book'));
}

// ルートモデルバインディング（現在の実装）
public function show(Book $book): View
{
    return view('admin/book/show', compact('book'));
}
```
