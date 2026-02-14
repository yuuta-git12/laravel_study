{{--
    書籍一覧テーブルコンポーネント
    書籍データをテーブル形式で表示するコンポーネント
    親ビューから$books（Bookモデルのコレクション）を受け取り、一覧表示する
    使用例: <x-book-table :$books />
--}}
<table border="1">
    <tr>
        <th>インデックス</th>
        <th>カテゴリ</th>
        <th>書籍名</th>
        <th>価格</th>
    </tr>
    {{-- $booksコレクションをループし、各書籍の情報を行として表示 --}}
    @foreach($books as $book)
        {{-- $loop->evenで偶数行に背景色を付けて視認性を向上させる --}}
        <tr @if($loop->even) style="background:#EEE" @endif>
            {{-- $loop->indexで0始まりのインデックスを表示 --}}
            <td>{{$loop->index}}</td>
            {{-- リレーション経由でカテゴリ名を取得 --}}
            <td>{{$book->category->title}}</td>
            <td>{{$book->title}}</td>
            <td>{{$book->price}}</td>
        </tr>
    @endforeach
</table>
