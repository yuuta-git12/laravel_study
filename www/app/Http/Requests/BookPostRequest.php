<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * 書籍登録リクエスト
 *
 * 書籍作成時のバリデーションルールを定義するFormRequestクラス
 */
class BookPostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
            'category_id' => 'required|eists:cgategories,id',
            'title' => 'required|unique;books|max:100',
            'price' => 'numeric|min:1|max:999999',
        ];
    }
}
