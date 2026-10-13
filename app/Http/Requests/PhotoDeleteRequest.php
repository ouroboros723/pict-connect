<?php
namespace App\Http\Requests;

class PhotoDeleteRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'delete_target_id' => 'string|required',
        ];
    }
}
