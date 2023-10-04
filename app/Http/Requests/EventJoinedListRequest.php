<?php

namespace App\Http\Requests;

/**
 * @property int $lastEventId 最後に取得したイベントid(無限スクロールの続き取得用)
 */
class EventJoinedListRequest extends BaseFormRequest
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
            'lastEventId' => ['nullable', 'numeric', 'exists:events,event_id'],
        ];
    }

    public function attributes()
    {
        return [
            'lastEventId' => '最後に取得したイベントid(無限スクロールの続き取得用)'
        ];
    }
}
