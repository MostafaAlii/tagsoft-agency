<?php

namespace Core\Exceptions;

use Core\Traits\ApiResponse;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class CustomExceptionHandler
{
    use ApiResponse;

    public function register(Exceptions $exceptions): void
    {
        $exceptions->render(function (Throwable $e, $request) {
            if ($request->is('api/*') || $request->wantsJson()) {
                if ($e instanceof ValidationException) {
                    return $this->errorResponse('Validation failed', $e->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
                }

                if ($e instanceof AuthenticationException) {
                    return $this->errorResponse('Unauthenticated access', null, Response::HTTP_UNAUTHORIZED);
                }

                if ($e instanceof ModelNotFoundException || $e instanceof NotFoundHttpException) {
                    return $this->errorResponse('Resource not found', null, Response::HTTP_NOT_FOUND);
                }

                return $this->errorResponse(
                    config('app.debug') ? $e->getMessage() : 'Internal server error',
                    null,
                    Response::HTTP_INTERNAL_SERVER_ERROR
                );
            }
        });
    }
}