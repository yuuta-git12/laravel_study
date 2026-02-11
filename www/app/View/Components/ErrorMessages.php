<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Support\ViewErrorBag;

/**
 * エラーメッセージ表示コンポーネント
 *
 * バリデーションエラーを一覧表示するためのBladeコンポーネントクラス。
 * 最大2件までのエラーメッセージを表示し、3件以上ある場合は省略表示する。
 *
 * 使用例: <x-error-messages :$errors />
 */
class ErrorMessages extends Component
{
    /**
     * バリデーションエラーを格納するプロパティ
     */
    public ViewErrorBag $errors;
    /**
     * Create a new component instance.
     */
    public function __construct(ViewErrorBag $errors)
    {
        // メンバ変数の値はコンストラクタ引数で外から受け取る
        $this->errors = $errors;
    }

    /**
     * エラーが2件以上あるかどうかを返す
     */
    public function has2MoreErrors(): bool
    {
        return count($this->errors) > 2;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.error-messages');
    }
}
