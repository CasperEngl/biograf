<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShowingDatePickRequest extends FormRequest
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
            'page' => ['numeric', 'between:1,99'],
        ];
    }

    public function attributes()
    {
        return [
            'page' => trans('showing.pick.attributes.page'),
        ];
    }
}
