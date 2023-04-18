<?php

namespace App\Helpers;

use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;

class MyHttpRequest
{
    public function validateBadRequest($validator)
    {
        $errors = (new ValidationException($validator))->errors();

        throw new HttpResponseException(response()->json(
            [
                'success' => false,
                'code' => 400,
                'message' => 'Bad Request',
                'data' => $errors
            ],
            400
        ));
    }
}
