<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;

abstract class BaseApiController extends Controller
{
    public function success($message, $data, $status = 200){
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data
        ], $status);
    }

    public function error($message, $data, $status = 400){
        return response()->json([
            'success' => false,
            'message' => $message,
            'data' => $data
        ], $status);
    }
}
