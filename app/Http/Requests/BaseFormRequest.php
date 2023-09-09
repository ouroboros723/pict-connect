<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BaseFormRequest extends FormRequest
{
    protected bool $enableQueryParamCheck = true;

    /**
     * バリーデーションのためにデータを準備
     * @return void
     */
    protected function prepareForValidation()
    {
        if($this->enableQueryParamCheck) {
            //getで取得したクエリパラメータをmergeする。
            foreach($this->query() as $key => $value) {
                $this->merge([$key => $value]);
            }
        }
    }
}
