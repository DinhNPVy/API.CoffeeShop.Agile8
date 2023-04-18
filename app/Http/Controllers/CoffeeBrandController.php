<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\MyHttpResponse;
use App\Http\Requests\CoffeeBrand\CoffeeBrandStoreRequest;
use App\Http\Requests\CoffeeBrand\CoffeeBrandUpdateRequest;
use App\Models\CoffeeBrand;

class CoffeeBrandController extends Controller
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
            $data = CoffeeBrand::all();
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
    public function store(CoffeeBrandStoreRequest $request)
    {
        try {


            $data = [
                'name' => $request->name
            ];

            // insert data
            CoffeeBrand::create($data);

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
            $data = CoffeeBrand::where('id', $id)->first();
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
    public function update(CoffeeBrandUpdateRequest $request, $id)
    {
        try {
            $coffeeBrand = CoffeeBrand::find($id);
            if (!$coffeeBrand = empty($coffeeBrand) ? [] : $coffeeBrand) {
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

            $coffeeBrand->update($data);

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
            $coffeeBrand = CoffeeBrand::find($id);
            if (!$coffeeBrand = empty($coffeeBrand) ? [] : $coffeeBrand) {
                return $this->myHttpResponse->response(
                    false, 
                    [], 
                    MyHttpResponse::HTTP_NOT_FOUND, 
                    MyHttpResponse::NOT_FOUND_MESSAGE
                );
            }

            $coffeeBrand->delete();

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
