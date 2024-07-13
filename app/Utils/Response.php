<?php

namespace App\Utils;

class Response
{
    public static function success(string $message = 'success', mixed $data = null, array $paging = null)
    {
        $response = [
            'success' => true,
            'data' => $data,
            'message' => $message,
            'paging' => $paging,
        ];

        return $response;
    }

    public static function error($statusCode = 400, $message = null)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
        ], $statusCode);
    }
}