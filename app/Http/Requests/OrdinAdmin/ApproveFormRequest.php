<?php

namespace App\Http\Requests\OrdinAdmin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ApproveFormRequest extends FormRequest
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
            'form_id' => 'required|alpha_num',
            'judge'   => 'required|boolean',
            'message' => 'max:255',
            'token'   => 'required|alpha_dash'
        ];
    }

    /**
     * @param Validator $validator
     */
    protected function failedValidation(Validator $validator)
    {
        throw (new HttpResponseException(\json_fail(422, '参数错误!', $validator->errors()->all(), 422)));
    }
}
