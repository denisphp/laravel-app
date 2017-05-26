<?php

namespace App\Services;

use Symfony\Component\HttpFoundation\Response;

class ApiResponse
{
    public function success($data = null)
    {
        $response = [
            'status' => 'ok',
            'data' => $data
        ];

        return response()->json($response, Response::HTTP_OK);
    }

    public function fail($code, $data = [])
    {
        $response = [
            'status' => 'error',
            'code' => $code,
            'message' => Response::$statusTexts[$code],
            'data' => $data
        ];

        return response()->json($response, $code);
    }
}
