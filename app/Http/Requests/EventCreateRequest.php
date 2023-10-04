<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;

/**
 * @property string $eventName
 * @property string $eventDetail
 * @property string $description
 * @property UploadedFile $icon
 * @property string $eventPeriodStart
 * @property string $eventPeriodEnd
 */
class EventCreateRequest extends BaseFormRequest
{
//    public function authorize()
//    {
//        return true;
//    }

    public function rules(): array
    {
        return [
            'eventName' => ['required', 'string'],
            'eventDetail' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'eventPeriodStart' => ['required', 'date'],
            'eventPeriodEnd' => ['required', 'date'],
            'icon' => ['nullable', 'file', 'image'],
        ];
    }

    public function attributes(){
        return [
            'eventName' => 'イベント名',
            'eventDetail' => 'イベント詳細',
            'description' => '備考',
            'icon' => 'イベントアイコン',
            'eventPeriodStart' => 'イベント開催期間(開始)',
            'eventPeriodEnd' => 'イベント開催期間(終了)',
        ];
    }
}
