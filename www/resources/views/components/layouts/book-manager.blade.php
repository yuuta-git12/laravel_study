{{--
    書籍管理システム共通レイアウトコンポーネント
    書籍管理画面の共通レイアウト（ヘッダー・フッター）を定義するレイアウトコンポーネント
    名前付きスロット$titleでページタイトルを、デフォルトスロット$slotでメインコンテンツを受け取る
    使用例: <x-layouts.book-manager><x-slot:title>ページ名</x-slot:title>コンテンツ</x-layouts.book-manager>
--}}
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    {{-- 名前付きスロットで各ページのタイトルを動的に設定 --}}
    <title>{{ $title }}</title>
</head>
<body>
    <head>
        書籍管理システム
        <hr>
    </head>
    <main>
        {{-- デフォルトスロットで各ページのメインコンテンツを表示 --}}
        {{ $slot }}
    </main>
    <footer>
        <hr>
        @Laravel
    </footer>
</body>
</html>
