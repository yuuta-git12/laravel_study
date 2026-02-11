{{--
    エラーメッセージ表示コンポーネント
    バリデーションエラーを一覧表示するための再利用可能なBladeコンポーネント
    最大2件までのエラーを表示し、それ以上ある場合は「...以下略」と表示する

    使用方法: <x-error-messages :$errors />
    必要な変数: $errors (ViewErrorBag) - バリデーションエラーを格納したオブジェクト
--}}
<div style="color:red">
    <ul>
        {{-- エラーメッセージを最大2件まで表示 --}}
        @foreach($errors->all() as $error)
            <li>{{$error}}</li>
            {{-- 2件目以降はループを抜ける --}}
            @if ($loop->iteration >= 2)
                @break
            @endif
        @endforeach
        {{-- エラーが3件以上ある場合は省略表示 --}}
        @if($has2MoreErrors())
            ...以下略
        @endif
    </ul>
</div>
