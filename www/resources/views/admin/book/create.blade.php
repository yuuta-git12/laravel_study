{{--
    書籍登録画面
    管理者向けの書籍新規登録フォームを表示するビュー
--}}
<x-layouts.book-manager>
    <x-slot:title>
        書籍登録
    </x-slot:title>
    <h1>書籍登録</h1>
    @if ($errors->any())
        {{--  class属性dangerを追加  --}}
        <x-alert class="danger">
            <x-error-messages :$errors />
        </x-alert>
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
</x-layouts.book-manager>
