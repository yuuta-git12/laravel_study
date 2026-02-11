{{--
    書籍登録画面
    管理者向けの書籍新規登録フォームを表示するビュー
--}}
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>書籍登録</title>
</head>
<body>
    <main>
        <h1>書籍登録</h1>
        @if ($errors->any())
            <x-error-messages :$errors />
        @endif
        {{-- web.phpで設定したルーティング名にすることが可能 --}}
        <form action="{{ route('book.store') }}" method="POST">
            @csrf
            {{--
                old()ヘルパー関数について:
                バリデーションエラー発生時に、直前のリクエストで入力された値を復元するための関数。
                フォーム送信でエラーが発生した際、ユーザーが再入力する手間を省くために使用する。
                セッションに一時保存された入力値を取得し、該当がなければnullを返す。
            --}}
            <div>
                <label>カテゴリ</label>
                <select name="category_id">
                    @foreach ($categories as $category)
                        {{-- old('category_id')で直前に選択されたカテゴリIDを取得し、一致する場合にselectedを付与 --}}
                        <option value="{{ $category->id }}"
                            @selected($category->id == old('category_id'))>
                            {{ $category->title }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label>タイトル</label>
                {{-- old('title')で直前に入力されたタイトルを復元 --}}
                <input type="text" name="title"
                    value="{{old('title')}}">
            </div>
            <div>
                <label>価格</label>
                {{-- old('price')で直前に入力された価格を復元 --}}
                <input type="text" name="price"
                    value="{{old('price')}}">
            </div>
            <input type="submit" value="送信">
        </form>
    </main>

</body>
</html>
