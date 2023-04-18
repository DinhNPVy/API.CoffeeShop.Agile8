<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\MyHttpResponse;
use App\Http\Requests\Coffee\CoffeeStoreRequest;
use App\Http\Requests\Coffee\CoffeeUpdateRequest;
use App\Models\Coffee;

class CoffeeController extends Controller
{
    private  MyHttpResponse $myHttpResponse;

    const DIRECTORY_NOT_EXISTS = 'Directory doesn\'t exists';

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
            $data = Coffee::with('coffeeBrand', 'coffeeType')->get();
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
    public function store(CoffeeStoreRequest $request)
    {
        try {

            $image = $request->image;
            $image_name = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
            $image_extension = $image->getClientOriginalExtension();

            $upload_path = config('coffeeshop.coffee_image_path');

            // check if coffee image path directory exists
            if (!file_exists($upload_path)) {
                return $this->myHttpResponse->response(
                    false, 
                    [], 
                    MyHttpResponse::HTTP_NOT_FOUND, 
                    self::DIRECTORY_NOT_EXISTS
                ); 
            }

            $image_fullname = $image_name . time() . '.' . $image_extension;
            
            // move image to coffee image folder
            $image->move($upload_path, $image_fullname);

            $data = [
                'name' => $request->name, 
                'image' => $image_fullname, 
                'status' => 1, 
                'price' => $request->price, 
                'type' => $request->type, 
                'brand' => $request->brand, 
                'description' => $request->description
            ];

            // insert data
            Coffee::create($data);

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
            $data = Coffee::where('id', $id)->with('coffeeBrand', 'coffeeType')->first();
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
    public function update(CoffeeUpdateRequest $request, $id)
    {
        try {
            $coffee = Coffee::find($id);
            if (!$coffee = empty($coffee) ? [] : $coffee) {
                return $this->myHttpResponse->response(
                    false, 
                    [], 
                    MyHttpResponse::HTTP_NOT_FOUND, 
                    MyHttpResponse::NOT_FOUND_MESSAGE
                );
            }

            $data = [
                'name' => $request->name, 
                'price' => $request->price, 
                'type' => $request->type, 
                'brand' => $request->brand, 
                'description' => $request->description, 
                'status' => $request->status
            ];

            if ($request->image) {
                $image = $request->image;
                $image_name = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $image_extension = $image->getClientOriginalExtension();
                $image_old = $coffee->image;
    
                // move image to coffee image folder
                $upload_path = config('coffeeshop.coffee_image_path');

                if (!file_exists($upload_path)) {
                    return $this->myHttpResponse->response(
                        false, 
                        [], 
                        MyHttpResponse::HTTP_NOT_FOUND, 
                        self::DIRECTORY_NOT_EXISTS
                    ); 
                }

                if (file_exists($upload_path.$image_old)) {
                    unlink($upload_path.$image_old);
                }

                $image_fullname = $image_name . time() . '.' . $image_extension;
                $image->move($upload_path, $image_fullname);

                $data['image'] = $image_fullname;
            }

            $coffee->update($data);

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
            $coffee = Coffee::find($id);
            if (!$coffee = empty($coffee) ? [] : $coffee) {
                return $this->myHttpResponse->response(
                    false, 
                    [], 
                    MyHttpResponse::HTTP_NOT_FOUND, 
                    MyHttpResponse::NOT_FOUND_MESSAGE
                );
            }

            $image = $coffee->image;
            $upload_path = config('coffeeshop.coffee_image_path');

            if (!file_exists($upload_path)) {
                return $this->myHttpResponse->response(
                    false, 
                    [], 
                    MyHttpResponse::HTTP_NOT_FOUND, 
                    self::DIRECTORY_NOT_EXISTS
                ); 
            }

            if (file_exists($upload_path.$image)) {
                unlink($upload_path.$image);
            }

            $coffee->delete();

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

    public function toggleStatus($id)
    {
        try {
            $coffee = Coffee::find($id);
            if (!$coffee = empty($coffee) ? [] : $coffee) {
                return $this->myHttpResponse->response(
                    false, 
                    [], 
                    MyHttpResponse::HTTP_NOT_FOUND, 
                    MyHttpResponse::NOT_FOUND_MESSAGE
                );
            }

            $data['status'] = $coffee->status == 0 ? 1 : 0;
            $coffee->update($data);

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
}
