<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * 書籍登録リクエスト
 *
 * 書籍作成時のバリデーションルールを定義するFormRequestクラス
 * コントローラーのメソッドでタイプヒントとして使用することで、
 * 自動的にバリデーションが実行される
 */
class BookPostRequest extends FormRequest
{
    /**
     * リクエストの認可判定
     *
     * このリクエストを実行する権限があるかどうかを判定する
     * trueを返すと全てのユーザーがリクエスト可能
     * 認証済みユーザーのみに制限する場合はAuth::check()などを使用
     *
     * @return bool 認可する場合はtrue
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * バリデーションルールの定義
     *
     * リクエストデータに適用するバリデーションルールを返す
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // カテゴリID: 必須、categoriesテーブルに存在するIDであること
            'category_id' => 'required|exists:categories,id',
            // タイトル: 必須、booksテーブルでユニーク、最大100文字
            'title' => 'required|unique:books|max:100',
            // 価格: 数値、1以上999999以下
            'price' => 'numeric|min:1|max:999999',
            // 著者ID：必須、配列
            'author_ids' => 'required|array',
            // 配列author_idsの要素にバリデーションを実施、必須、著者テーブルに存在するID
            'author_ids.*' => 'required|exists:authors,id',
        ];
    }
}
