<?php
namespace App\Traits;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

trait JsonResponser
{
    // this function will return json success response
    private function successResponse($data,$code=200){
        return response()->json($data,$code);
    }

    //this will return single instance json response
    protected function oneResponse(Model $instance, $code=200)
    {
        return $this->successResponse($instance,$code);
    }

    //this will return multiple instance json response
    protected function mutliResponse(Collection $collection,$code=200)
    {
        return $this->successResponse($collection,$code);
    }
    // this will return error response with http error code
    protected function errorResponse($msg,$code)
    {
        return response()->json(['error'=>$msg,'code'=>$code],$code);
    }

    // this will return custom response
    protected function customResponse($msg_or_data,$code=200)
    {
        return response()->json($msg_or_data,$code);
    }
}