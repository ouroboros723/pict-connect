<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class PhotoRequest extends FormRequest
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
