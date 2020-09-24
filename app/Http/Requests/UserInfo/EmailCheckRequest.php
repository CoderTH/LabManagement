<?php

namespace App\Http\Requests\UserInfo;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class EmailCheckRequest extends FormRequest
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
            //
            'old_email'=>'required|regex:/^(\w)+(\.\w+)*@(\w)+((\.\w{2,3}){1,3})$/',
            'new_email'=>'required|regex:/^(\w)+(\.\w+)*@(\w)+((\.\w{2,3}){1,3})$/',
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
