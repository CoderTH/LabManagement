<?php

namespace App\Http\Requests\OrdinAdmin;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class FinalLabRequest extends FormRequest
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
            'lab_id'=>'required|max:18',
            'lab_name'=>'required|max:200',
            'class_name'=>'required',
            'teaching_operation'=>'required|max:200',
            'open_lab_operation'=>'required|max:200',
            'note'=>'required|max:200',
            'token'=>'required|alpha_dash'
        ];
    }

    /**
     * @param Validator $validator
     */
    protected function failedValidation(Validator $validator)
    {
        throw (new HttpResponseException(response()->fail(422, '参数错误!', $validator->errors()->all(), 422)));
    }
}

