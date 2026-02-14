{{--
    アラートコンポーネント
    フラッシュメッセージやエラーメッセージを表示するための汎用アラートコンポーネント
    class属性で表示スタイルを切り替える（danger: エラー用, info: 情報用）
    使用例: <x-alert class="danger">エラーメッセージ</x-alert>
--}}
{{-- $attributesでコンポーネントに渡された属性（class等）をそのまま展開する --}}
<div id="alert" {{ $attributes }}>
    {{-- $slotでコンポーネントタグの子要素を表示する --}}
    {{ $slot }}
</div>
{{-- 簡易的にコンポーネント内にスタイルを記述　本来は外部CSSファイルで定義する --}}
<style>
    #alert {
        width: 100%;
        padding: 5px;
        border: none;
        border-radius: 5px;
        box-sizing: border-box;
        background-color: #f2f2f2;
    }
    #alert.danger {
        background-color: #fff2f2;
        color: red;
    }
    #alert.info {
        background-color: #f2f2ff;
        color: blue;
    }
</style>
