<?php
namespace App\Http\Requests;

class PhotoRequest extends BaseFormRequest
{
//    public function authorize()
//    {
//        return true;
//    }

    public function rules(): array
    {
        return [
            'photo_data' => 'array|max:100',
            'photo_data.*' => 'bail|required|mimes:jpeg,bmp,png,gif',
        ];
    }
}
