<?php

namespace App\Http\Requests;

/**
 * @property int $lastEventParticipantsId 最後に取得したイベント参加者id(無限スクロールの続き取得用)
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
            'lastEventParticipantsId' => ['nullable', 'numeric', 'exists:event_participants,event_participants_id'],
        ];
    }

    public function attributes()
    {
        return [
            'lastEventParticipantsId' => '最後に取得したイベント参加者id(無限スクロールの続き取得用)'
        ];
    }
}
