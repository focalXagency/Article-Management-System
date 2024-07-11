<?php

namespace App\Http\Trait;

trait ApiResponseTrait{
    public function responseApi($data, $message, $status){
        $array = [
            'data' => $data,
            'message' => $message,
        ];
        return response()->json($array,$status);
    }
}