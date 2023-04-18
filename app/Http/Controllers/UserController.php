<?php

namespace App\Http\Controllers;


use App\Helpers\MyHttpResponse;
use App\Http\Requests\User\UserLoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserController extends Controller
{
    private  MyHttpResponse $myHttpResponse;

    const INVALID_CREDENTICALS = 'Invalid Credenticals';
    const LOGIN_SUCCESS = 'Login Success';
    const ADMIN = 'Administrator';

    public function __construct(MyHttpResponse $myHttpResponse)
    {
        $this->myHttpResponse = $myHttpResponse;
    }

    /**
     * Display a listing of the user.
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {

        return $this->myHttpResponse->response(
            true,
            [],
            MyHttpResponse::HTTP_OK,
            self::LOGIN_SUCCESS
        );
    }

    /**
     * User login.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \App\Helpers\MyHttpResponse
     */
    public function login(UserLoginRequest $request)
    {
        $credenticals = $request->all();
        if (!Auth::attempt(['username' => $credenticals['username'], 'password' => $credenticals['password']])) {
            return $this->myHttpResponse->response(
                false,
                [],
                MyHttpResponse::HTTP_BAD_REQUEST,
                self::INVALID_CREDENTICALS
            );
        }

        $access_token = User::where('username', $credenticals['username'])->first()->createToken('api_token')->accessToken;
    
        return $this->myHttpResponse->response(
            true,
            [
                'user' => Auth::user(),
                'access_token' => $access_token
            ],
            MyHttpResponse::HTTP_OK,
            self::LOGIN_SUCCESS
        );
    }

    /**
     * Admin login.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \App\Helpers\MyHttpResponse
     */
    public function loginAdmin(UserLoginRequest $request)
    {
        $credenticals = $request->all();

        if (!Auth::attempt(['username' => $credenticals['username'], 'password' => $credenticals['password']])) {
            return $this->myHttpResponse->response(
                false,
                [],
                MyHttpResponse::HTTP_BAD_REQUEST,
                self::INVALID_CREDENTICALS
            );
        }

        $user = User::where('username', $credenticals['username'])->first();

        if ($user->role->name != self::ADMIN) {
            return $this->myHttpResponse->response(
                false,
                [],
                MyHttpResponse::HTTP_BAD_REQUEST,
                self::INVALID_CREDENTICALS
            );
        }
        
        $access_token = $user->createToken('admin_api_token')->accessToken;

        return $this->myHttpResponse->response(
            true,
            [
                'user' => Auth::user(),
                'admin_access_token' => $access_token
            ],
            MyHttpResponse::HTTP_OK,
            self::LOGIN_SUCCESS
        );
    }
}
