<div>
    <label>カテゴリ</label>
    <select name="category_id">
        {{-- カテゴリ一覧をループしてオプションを生成 --}}
        @foreach($categories as $category)
            {{--
            old()ヘルパー関数について:
            バリデーションエラー発生時に、直前のリクエストで入力された値を復元するための関数。
            フォーム送信でエラーが発生した際、ユーザーが再入力する手間を省くために使用する。
            セッションに一時保存された入力値を取得し、該当がなければnullを返す。
            --}}
            {{--
                old()の第2引数：バリデーションエラーがない場合（初回表示時）のデフォルト値
                $book->category_idを指定することで、既存の書籍データを初期値として表示する
            --}}
            <option
                value="{{ $category->id }}"
                @selected(
                    $category->id == old('category_id', $book->category_id)
                )
            >
            {{ $category->title }}
            </option>
        @endforeach
    </select>
</div>
<div>
    <label>タイトル</label>
    {{-- old()の第2引数に$book->titleを指定し、初回表示時は既存のタイトルを表示 --}}
    <input type="text" name="title" value="{{ old('title', $book->title) }}">
</div>
<div>
    <label>価格</label>
    {{-- old()の第2引数に$book->priceを指定し、初回表示時は既存の価格を表示 --}}
    <input type="text" name="price" value="{{ old('price', $book->price) }}">
</div>
{{-- 著者選択エリア：チェックボックスで複数選択可能 --}}
<div>
    <label>著者</label>
    <ul>
        {{-- 著者一覧をループしてチェックボックスを生成 --}}
        @foreach($authors as $author)
            <li>
                <input type="checkbox" name="author_ids[]" value="{{ $author->id }}"
                    {{--
                        @checkedディレクティブ：条件がtrueの場合にchecked属性を出力する
                        old()の第2引数に$authorIds（書籍に紐づく著者IDの配列）を指定し、
                        初回表示時は既存の著者が選択された状態で表示する
                        バリデーションエラー時はold('author_ids')で直前の選択状態を復元する
                    --}}
                    @checked(
                        in_array(
                            $author->id,
                            old('author_ids', $authorIds)
                        )
                    )
                >
                {{ $author->name }}
            </li>
        @endforeach
    </ul>
</div>
