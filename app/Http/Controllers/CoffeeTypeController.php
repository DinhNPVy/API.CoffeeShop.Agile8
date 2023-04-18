<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\MyHttpResponse;
use App\Http\Requests\CoffeeType\CoffeeTypeStoreRequest;
use App\Http\Requests\CoffeeType\CoffeeTypeUpdateRequest;
use App\Models\CoffeeType;

class CoffeeTypeController extends Controller
{
    private  MyHttpResponse $myHttpResponse;

    public function __construct(MyHttpResponse $myHttpResponse)
    {
        $this->myHttpResponse = $myHttpResponse;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $data = CoffeeType::all();
            if (!$data = empty($data) ? [] : $data->toArray()) {
                return $this->myHttpResponse->response(
                    false, 
                    [], 
                    MyHttpResponse::HTTP_NOT_FOUND, 
                    MyHttpResponse::NOT_FOUND_MESSAGE
                );
            }
    
            return $this->myHttpResponse->response(
                true, 
                $data, 
                MyHttpResponse::HTTP_OK, 
                MyHttpResponse::GET_SUCCESS_MESSAGE
            );
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->myHttpResponse->response(
                true, 
                [], 
                MyHttpResponse::HTTP_INTERNAL_SERVER_ERROR, 
                $e->getMessage()
            ); 
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CoffeeTypeStoreRequest $request)
    {
        try {
            $data = [
                'name' => $request->name
            ];

            // insert data
            CoffeeType::create($data);

            return $this->myHttpResponse->response(
                true, 
                [], 
                MyHttpResponse::HTTP_CREATED, 
                MyHttpResponse::CREATE_SUCCESS_MESSAGE
            );
      
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->myHttpResponse->response(
                false, 
                [], 
                MyHttpResponse::HTTP_INTERNAL_SERVER_ERROR, 
                $e->getMessage()
            ); 
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $data = CoffeeType::where('id', $id)->first();
            if (!$data = empty($data) ? [] : $data->toArray()) {
                return $this->myHttpResponse->response(
                    false, 
                    [], 
                    MyHttpResponse::HTTP_NOT_FOUND, 
                    MyHttpResponse::NOT_FOUND_MESSAGE
                );
            }
            
            return $this->myHttpResponse->response(
                true, 
                $data, 
                MyHttpResponse::HTTP_OK, 
                MyHttpResponse::GET_SUCCESS_MESSAGE
            );         
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->myHttpResponse->response(
                false, 
                [], 
                MyHttpResponse::HTTP_INTERNAL_SERVER_ERROR, 
                $e->getMessage()
            ); 
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CoffeeTypeUpdateRequest $request, $id)
    {
        try {
            $coffeeType = CoffeeType::find($id);
            if (!$coffeeType = empty($coffeeType) ? [] : $coffeeType) {
                return $this->myHttpResponse->response(
                    false, 
                    [], 
                    MyHttpResponse::HTTP_NOT_FOUND, 
                    MyHttpResponse::NOT_FOUND_MESSAGE
                );
            }

            $data = [
                'name' => $request->name, 
            ];

            $coffeeType->update($data);

            return $this->myHttpResponse->response(
                true, 
                [], 
                MyHttpResponse::HTTP_OK, 
                MyHttpResponse::UPDATE_SUCCESS_MESSAGE
            );
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->myHttpResponse->response(
                false, 
                [], 
                MyHttpResponse::HTTP_INTERNAL_SERVER_ERROR, 
                $e->getMessage()
            ); 
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $coffeeType = CoffeeType::find($id);
            if (!$coffeeType = empty($coffeeType) ? [] : $coffeeType) {
                return $this->myHttpResponse->response(
                    false, 
                    [], 
                    MyHttpResponse::HTTP_NOT_FOUND, 
                    MyHttpResponse::NOT_FOUND_MESSAGE
                );
            }

            $coffeeType->delete();

            return $this->myHttpResponse->response(
                true, 
                [], 
                MyHttpResponse::HTTP_OK, 
                MyHttpResponse::DELETE_SUCCESS_MESSAGE
            );
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->myHttpResponse->response(
                false, 
                [], 
                MyHttpResponse::HTTP_INTERNAL_SERVER_ERROR, 
                $e->getMessage()
            ); 
        }
    }
}
