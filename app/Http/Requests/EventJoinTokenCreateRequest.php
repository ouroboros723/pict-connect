<?php

namespace App\Http\Requests;

class EventJoinTokenCreateRequest extends BaseFormRequest
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
            'expiredAt' => ['nullable', 'date'],
            'limitTimes' => ['nullable', 'integer','min:1','max:1000000000'],
        ];
    }

    public function attributes()
    {
        return [
            'expiredAt' => '有効期限',
            'limitTimes' => '使用可能回数',
        ];
    }
}
