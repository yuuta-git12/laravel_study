<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>Messages Sample</title>
    </head>
    <body>
        <main>
            <h1>Messages</h1>
            {{-- リクエストの送信先を指定 --}}
            <form action="/messages" method="post">
                {{-- CSRFトークンを付与 --}}
                @csrf
                {{-- フォームの入力フィールドを作成 --}}
                <input type="text" name="body" placeholder="メッセージを入力">
                <input type="submit" value="投稿">
            </form>
            <ul>
            <!-- メッセージの一覧を表示 -->
                @foreach ($messages as $message)
                <!-- メッセージテーブルのbodyカラムを表示 -->
                    <li>{{ $message->body }}</li>
                @endforeach
            </ul>
        </main>
    </body>
</html>
