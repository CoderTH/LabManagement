<?php

namespace App\Http\Requests\OrdinAdmin;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class OpenLabRequest extends FormRequest
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
            'use_reason'=>'required|max:200',
            'project_name'=>'required|max:200',
            'start_time'=>'required|date',
            'end_time'=>'required|date|after_or_equal:start_time',
            'date'=>'required|date',
            'token'=>'required'
        ];
    }

    /**
     * @param Validator $validator
     */
    protected function failedValidation(Validator $validator)
    {
        throw (new HttpResponseException(json_fail("参数错误",$validator->errors()->all(),422)));
    }
}
