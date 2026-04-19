{{--
    書籍更新画面
    管理者向けの書籍編集フォームを表示するビュー
--}}
<x-layouts.book-manager>
    <x-slot:title>
        書籍更新
    </x-slot:title>

    <h1>書籍更新</h1>
    {{-- バリデーションエラーがある場合、エラーメッセージを表示 --}}
    @if($errors->any())
        <x-alert class="danger">
            <x-error-messages :errors="$errors" />
        </x-alert>
    @endif
    <form action="{{ route('book.update', $book) }}" method="POST">
        @csrf
        {{-- HTMLフォームはPUTメソッドを直接サポートしないため、@methodディレクティブで擬似的にPUTリクエストを送信する --}}
        @method('PUT')
        <x-book-form :$categories :$authors :$book :$authorIds />
        <input type="submit" value="送信">
    </form>
</x-layouts.book-manager>
