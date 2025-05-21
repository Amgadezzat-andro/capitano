<?php
namespace App\Trait;
trait JsonResponsable

{
    public function success( $code , $data,$message='success')
    {
        return response()->json([
            'message'=>$message,
            'data'=>$data
        ],$code);
    }


    public function failure($code , $message)
    {
        return response()->json([
            'message'=>$message,
            
        ],$code);
    }
}