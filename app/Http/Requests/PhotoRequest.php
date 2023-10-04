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
            'files.*.photo_data' => 'bail|required|mimes:jpeg,bmp,png,gif',
        ];
    }
}
