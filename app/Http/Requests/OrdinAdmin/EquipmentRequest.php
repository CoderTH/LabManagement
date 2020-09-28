<?php

namespace App\Http\Requests\OrdinAdmin;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class EquipmentRequest extends FormRequest
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
            'useinfo'=>'required|max:200',
            'department'=>'required|max:200',
            'start_time'=>'required|date',
            'expect_time'=>'required|date|after_or_equal:start_time',
            'borrow_name'=>'required|max:200',
            'phone'=>'required|between:11,11',
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
