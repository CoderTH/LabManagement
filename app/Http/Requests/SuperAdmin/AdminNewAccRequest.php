<?php

namespace App\Http\Requests\SuperAdmin;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class AdminNewAccRequest extends FormRequest
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
            'permission_id' => 'required|integer|between:2,7',
            'status' => 'required|integer|between:0,1',
            'token' => 'required|alpha_dash',
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
