{{--
    書籍一覧画面
    管理者向けの書籍一覧を表示するビュー
    カテゴリ・書籍名・価格を一覧表示し、新規登録へのリンクを提供する
--}}
<x-layouts.book-manager>
    <x-slot:title>
        書籍一覧
    </x-slot:title>
    <h1>書籍一覧</h1>
    {{-- フラッシュメッセージの表示（登録・更新・削除後のメッセージ） --}}
    @if(session('message'))
        <x-alert class="info">
            {{ session('message') }}
        </x-alert>
    @endif
    {{-- 書籍登録画面へのリンク --}}
    <a href="{{ route('book.create') }}">追加</a>
    <x-book-table :$books />
</x-layouts.book-manager>
