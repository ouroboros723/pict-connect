<?php

namespace App\Http\Requests;

/**
 * @property string $confirmText 削除確認テキスト
 */
class EventDeleteRequest extends BaseFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'confirmText' => ['required', 'string', 'in:delete'],
        ];
    }

    public function attributes()
    {
        return [
            'confirmText' => '削除確認テキスト'
        ];
    }
}
