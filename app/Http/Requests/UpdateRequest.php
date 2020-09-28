<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateRequest extends FormRequest
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
            //'token'=>'required|alpha_dash',
            'form_id'=>'required|string',
            'weeks' => 'required|int',
            'created_at'=>'required|date',
            'professional_classes'=>'required|string',
            'student_name'=>'required|string',
            'number'=>'required|int',
            'class_name'=>'required|string',
            'class_type'=> 'required|string',
            'teacher_name'=>'required|string',
            'device_run_condition'=>'required|string',
            'note'=>'required|string'
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
