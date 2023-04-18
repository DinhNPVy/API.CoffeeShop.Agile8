<?php

namespace App\Http\Requests\Coffee;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use App\Helpers\MyHttpRequest;

class CoffeeUpdateRequest extends FormRequest
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
            'name'        => 'required|unique:coffees,name,' . $this->id, 
            'image'       => 'image', 
            'price'       => 'required|numeric', 
            'type'        => 'required|integer', 
            'brand'       => 'required|integer', 
            'description' => 'required', 
            'status'      => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required'        => 'Coffee name is required', 
            'name.unique'          => 'Coffee name already exist', 
            'image.image'          => 'Coffee image file type must be jpg, jpeg, png, bmp, gif, svg, or webp', 
            'price.required'       => 'Coffee price is required', 
            'price.numeric'        => 'Coffee price must be numeric', 
            'type.required'        => 'Coffee type is required', 
            'type.integer'         => 'Coffee type value is invalid', 
            'brand.required'       => 'Coffee brand is required', 
            'brand.integer'        => 'Coffee type value is invalid', 
            'description.required' => 'Coffee description is required',
            'status.required'      => 'Coffee status is required' 
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $this->myHttpRequest->validateBadRequest($validator);
    }
}
