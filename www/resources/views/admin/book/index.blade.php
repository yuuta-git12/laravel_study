{{--
    書籍一覧画面
    管理者向けの書籍一覧を表示するビュー
    カテゴリ・書籍名・価格を一覧表示し、新規登録へのリンクを提供する
--}}
<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>書籍一覧</title>
    </head>
    <body>
        <main>
            <h1>書籍一覧</h1>
            {{-- フラッシュメッセージの表示（登録・更新・削除後のメッセージ） --}}
            @if(session('message'))
                <div style="color: blue">
                    {{ session('message') }}
                </div>
            @endif
            {{-- 書籍登録画面へのリンク --}}
            <a href="{{ route('book.create') }}">追加</a>
            {{-- 書籍一覧テーブル --}}
            <table border="1">
                <tr>
                    <th>カテゴリ</th>
                    <th>書籍名</th>
                    <th>価格</th>
                </tr>
                @foreach($books as $book)
                    <tr>
                        <td>{{$book->category->title}}</td>
                        <td>{{$book->title}}</td>
                        <td>{{$book->price}}</td>
                    </tr>
                @endforeach
            </table>
        </main>
    </body>
</html>
