<?php

namespace App\Helpers;

use Illuminate\Http\Response;

class MyHttpResponse
{
    public const HTTP_OK                       = 200;
    public const HTTP_CREATED                  = 201;
    public const HTTP_NO_CONTENTS              = 204;
    public const HTTP_BAD_REQUEST              = 400;
    public const HTTP_UNAUTHORIZED             = 401;
    public const HTTP_FORBIDDEN                = 403;
    public const HTTP_NOT_FOUND                = 404;
    public const HTTP_INTERNAL_SERVER_ERROR    = 500;

    public const CREATE_SUCCESS_MESSAGE        = 'Created Success';
    public const UPDATE_SUCCESS_MESSAGE        = 'Updated Success';
    public const DELETE_SUCCESS_MESSAGE        = 'Deleted Success';
    public const GET_SUCCESS_MESSAGE           = 'Get Data Success';
    public const VALIDATION_ERROR_MESSAGE      = 'Validation Fail';
    public const BAD_REQUEST_MESSAGE           = 'Bad Request';
    public const UNAUTHORIZED_MESSAGE          = 'Unauthorized';
    public const FORBIDDEN_MESSAGE             = 'Forbidden';
    public const NOT_FOUND_MESSAGE             = 'Not Found';
    public const INTERNAL_SERVER_ERROR_MESSAGE = 'Internal Server Error';

    public function response(bool $success = true, array $data = [], int $code = self::HTTP_OK, string $message = self::GET_SUCCESS_MESSAGE): Response
    {
        $result['success'] = $success;
        $result['code'] = $code;
        $result['message'] = $message;
        $result['data'] = $data;

        return new Response($result, $code);
    }
}
