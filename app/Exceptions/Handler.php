<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use ReflectionClass;
use Throwable;

class Handler extends ExceptionHandler
{
    protected $handlersPrefix = '\App\Exceptions\Handlers\\';

    public function render($request, \Throwable $exception)
    {
        $handlerName = $this->handlersPrefix . (new ReflectionClass($exception))->getShortName() . 'Handler';

        if (class_exists($handlerName)) return (new $handlerName())->response($exception);

        $statusCode = $exception->getCode() > 0 && $exception->getCode() <= 500 ? $exception->getCode() : 500;
        $response = ['message' => $exception->getMessage()];

        return new JsonResponse(
            $response,
            $statusCode,
            [],
            JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES
        );
    }
}
