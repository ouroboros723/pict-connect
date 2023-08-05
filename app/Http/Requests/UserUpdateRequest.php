<?php
namespace App\Http\Requests;
use Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
{
//    public function authorize()
//    {
//        return true;
//    }

    public function rules(): array
    {
        $rules = [
            'screen_name' => ['required', 'string', 'max:255', Rule::unique('users')->ignore(Auth::user()->screen_name, 'screen_name')],
            'view_name' => ['required', 'string', 'max:255'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'user_icon' => ['nullable', 'file'], //mimetypeが正しく判定できないのでいったん解除
        ];

        if(Auth::user()->is_from_sns) {
            $rules['email'] = ['nullable', 'string', 'min:8', 'email:rfc', Rule::unique('users')->ignore(Auth::user()->email, 'email')];
        } else {
            $rules['email'] = ['required', 'string', 'min:8', 'email:rfc', Rule::unique('users')->ignore(Auth::user()->email, 'email')];
        }

        return $rules;
    }

    public function attributes()
    {
        return [
            'screen_name' => 'ユーザーid',
            'view_name' => '表示名',
            'email' => 'メールアドレス',
            'password' => 'パスワード',
            'user_icon' => 'アイコン画像',
        ];
    }
}
