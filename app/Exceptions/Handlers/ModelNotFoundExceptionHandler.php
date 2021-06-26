<?php

namespace App\Exceptions\Handlers;

class ModelNotFoundExceptionHandler
{
    public function response() {
        $response = [];

        $response['message'] = 'Resource not found';

        return response()->json($response, 404);
    }
}
