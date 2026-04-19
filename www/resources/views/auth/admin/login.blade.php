<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ログイン</title>
</head>
<body>
    {{-- バリデーションエラーがある場合にエラーメッセージを表示 --}}
    @if($errors->any())
        <x-alert class="danger">
            <x-error-messages :errors="$errors" />
        </x-alert>
    @endif
    {{-- ログインフォーム: admin.storeルート(POST /admin/login)へ送信 --}}
    <form method="POST" action="{{ route('admin.store') }}">
        {{-- CSRF攻撃対策トークン --}}
        @csrf
        <div>
            <div>
                ログインID:<input type="text" name="login_id">
            </div>
            <div>
                {{-- TODO: type="password"に変更してパスワードを非表示にする --}}
                パスワード:<input type="password" name="password">
            </div>
        </div>
        <div>
            <input type="submit" value="ログイン">
        </div>
    </form>
</body>
</html>
