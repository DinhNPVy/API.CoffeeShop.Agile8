<?php

namespace App\Http\Requests\CoffeeBrand;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use App\Helpers\MyHttpRequest;

class CoffeeBrandUpdateRequest extends FormRequest
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
            'name' => 'required|unique:coffee_brands,name,' . $this->id, 
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Coffee brand name is required', 
            'name.unique'   => 'Coffee brand name already exists', 
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $this->myHttpRequest->validateBadRequest($validator);
    }
}
