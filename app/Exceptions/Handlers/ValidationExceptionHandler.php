<?php

namespace App\Exceptions\Handlers;

class ValidationExceptionHandler
{
    public function response($exception) {
        $response = [];

        $response['message'] = $exception->getMessage() ?? 'The given data was invalid.';

        foreach ($exception->errors() as $key => $value) {
            $response['errors'][$key] = $value[0];
        }

        return response()->json($response, 422);

    }
}
