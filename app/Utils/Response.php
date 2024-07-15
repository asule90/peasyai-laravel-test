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

    public static function error($statusCode = 422, $message = null)
    {
        if ( !is_int($statusCode) || ($statusCode < 100 || $statusCode >= 600)) {
            $statusCode = 422;
        }

        return response()->json([
            'success' => false,
            'message' => $message,
        ], $statusCode);
    }
}