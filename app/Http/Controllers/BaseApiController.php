<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;

abstract class BaseApiController extends Controller
{
    public function success($message, $data = null, $status = 200){
        $response = [
            'message' => $message,
        ];

        if(!is_null($data)){
            $response['data'] = $data;
        }

        return response()->json($response, $status);
    }

    public function error($message, $data, $status = 400){
        return response()->json([
            'message' => $message,
            'data' => $data
        ], $status);
    }
}
