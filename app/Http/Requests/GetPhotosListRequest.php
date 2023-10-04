<?php

namespace App\Http\Requests;

/**
 * @property mixed $event_id イベントid
 * @property mixed $last_photo_id 最後に取得した写真id(無限スクロールの続き取得用)
 */
class GetPhotosListRequest extends BaseFormRequest
{
    protected bool $enableQueryParamCheck = false;

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
            'event_id' => ['required', 'numeric', 'exists:events,event_id'],
            'last_photo_id' => ['nullable', 'numeric', 'exists:photos,photo_id'],
        ];
    }

    public function attributes()
    {
        return [
            'event_id' => 'イベントid',
            'last_photo_id' => '最後に取得した写真id(無限スクロールの続き取得用)',
        ];
    }
}
