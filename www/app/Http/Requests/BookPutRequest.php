<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * 書籍更新リクエスト
 *
 * 書籍更新時のバリデーションルールを定義するFormRequestクラス
 * BookPostRequestとの違い：titleにunique制約がない（自身のタイトルと重複を許可するため）
 * コントローラーのメソッドでタイプヒントとして使用することで、
 * 自動的にバリデーションが実行される
 */
class BookPutRequest extends FormRequest
{
    /**
     * リクエストの認可判定
     *
     * このリクエストを実行する権限があるかどうかを判定する
     * trueを返すと全てのユーザーがリクエスト可能
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
            // タイトル: 必須、最大100文字（更新時はunique制約なし）
            'title' => 'required|max:100',
            // 価格: 数値、1以上999999以下
            'price' => 'numeric|min:1|max:999999',
            // 著者ID：必須、配列
            'author_ids' => 'required|array',
            // 配列author_idsの要素にバリデーションを実施、必須、著者テーブルに存在するID
            'author_ids.*' => 'required|exists:authors,id',
        ];
    }
}
