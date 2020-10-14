<?php

namespace App\Http\Requests\SuperAdmin;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StudentNewAccRequest extends FormRequest
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

    public function rules()
    {
        return [
            'work_id' => 'required|integer|unique:user|unique:user_info,user_id',
            'name' => 'required|string',
            'phone' => 'required|integer|digits_between:11,11|unique:user_info',
            'email' => 'required|email|unique:user_info',
            'token' => 'required',
        ];
    }
    /**
     * @param Validator $validator
     */
    protected function failedValidation(Validator $validator)
    {
        throw (new HttpResponseException(json_fail('参数错误!',$validator->errors()->all(),100)));
    }
}
