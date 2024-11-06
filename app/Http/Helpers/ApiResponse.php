<?php
namespace App\Http\Helpers;

class ApiResponse {
    public static function success($message, $data = null)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data
        ], 200);
    }

    public static function error($message, $code = 400)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
        ], $code);
    }

    public static function validationError($errors = null)
    {
        return response()->json([
            'success'=> false,
            'message' => 'Validation Error',
            'errors'=> $errors
        ], 400);
    }
}