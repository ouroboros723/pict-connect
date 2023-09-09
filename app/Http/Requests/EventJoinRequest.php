<?php

namespace App\Http\Requests;

/**
 * @property mixed $joinToken イベント参加トークン
 */
class EventJoinRequest extends BaseFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'joinToken' => ['required', 'string'],
        ];
    }

    public function attributeNames(){
        return [
            'joinToken' => '参加トークン',
        ];
    }
}
