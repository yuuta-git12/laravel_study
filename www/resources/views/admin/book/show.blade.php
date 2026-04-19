{{--
    書籍詳細画面
    管理者向けの書籍詳細情報を表示するビュー
    BookControllerのshowメソッドから暗黙のルートモデルバインディングで取得した$bookを受け取る
--}}
<x-layouts.book-manager>
    <x-slot:title>
        書籍詳細
    </x-slot:title>
    <h1>書籍詳細</h1>
    <ul>
        <li>ID:{{ $book->id }}</li>
        {{-- リレーション経由でカテゴリ名を取得 --}}
        <li>カテゴリ:{{ $book->category->title }}</li>
        <li>タイトル:{{ $book->title }}</li>
        {{-- 多対多リレーション経由で著者一覧を取得・表示 --}}
        <li>著者:
            <ul>
                @foreach($book->authors as $author)
                    <li>{{ $author->name }}</li>
                @endforeach
            </ul>
        </li>
    </ul>
    {{-- 書籍一覧画面へ戻るリンク --}}
    <a href="{{ route('book.index') }}">戻る</a>
</x-layouts.book-manager>
