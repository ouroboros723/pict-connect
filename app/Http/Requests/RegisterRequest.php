<?php
namespace App\Http\Requests;

class RegisterRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'screen_name' => ['required', 'string', 'max:255', 'unique:users,screen_name'],
            'view_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'min:8', 'email:rfc', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'user_icon' => ['nullable', 'file'], //mimetypeが正しく判定できないのでいったん解除
        ];
    }
}
