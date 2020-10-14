<?php

namespace App\Http\Requests\OrdinAdmin;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class LabBorrowingRequest extends FormRequest
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
            'date' => 'required|date',
            'lab_name' => 'required|max:200',
            'lab_id' => 'required|max:18',
            'class_name' => 'required|max:200',
            'class' => 'required|max:200',
            'number' => 'required|max:18',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after_or_equal:start_time',
            'start_class' => 'required|max:18',
            'end_class' => 'required|min:start_class',
            'phone' => 'required|between:11,11',
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
