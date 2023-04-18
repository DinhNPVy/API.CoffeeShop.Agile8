<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use App\Helpers\MyHttpRequest;

class UserLoginRequest extends FormRequest
{
    private MyHttpRequest $myHttpRequest;

    public function __construct(MyHttpRequest $myHttpRequest)
    {
        $this->myHttpRequest = $myHttpRequest;
    }

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
            'username' => 'required',
            'password' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'username.required' => 'Username is required',
            'password.required' => 'Password is required',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $this->myHttpRequest->validateBadRequest($validator);
    }
}
