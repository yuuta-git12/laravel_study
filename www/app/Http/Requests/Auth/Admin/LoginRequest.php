<?php

namespace App\Http\Requests\Auth\Admin;

use App\Http\Middleware\Authenticate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

/**
 * 管理者用のLoginRequetsクラス
 */
class LoginRequest extends FormRequest
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
            'login_id' => ['required', 'string'],
            'password' => ['required', 'string', 'max:15', Password::min(1)->numbers()->symbols()],
        ];
    }

    /**
     * adminガードを使用して認証を試みる
     * 認証失敗時はバリデーションエラーをスロー
     */
    public function authenticate(): void{
        // adminガードでlogin_idとpasswordによる認証を試みる
        if(! Auth::guard('admin')->attempt($this->only('login_id', 'password'))){
            // 認証失敗時: auth.phpの'failed'メッセージでバリデーションエラーを発生させる
            throw ValidationException::withMessages([
                'login_id' => trans('auth.failed'),
            ]);
        }
    }
}
