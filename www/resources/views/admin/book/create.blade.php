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
        {{-- CSRF(クロスサイトリクエストフォージェリ)対策用の隠しトークンを埋め込む --}}
        @csrf
        <x-book-form :$categories :$authors />
        <input type="submit" value="送信">
    </form>
</x-layouts.book-manager>
