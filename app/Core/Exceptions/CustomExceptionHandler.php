<?php
declare(strict_types=1);
namespace Core\Exceptions;
use Core\Traits\ApiResponse;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Tymon\JWTAuth\Exceptions\{JWTException,TokenExpiredException,TokenInvalidException};
use Throwable;
use Core\Contracts\HasHttpStatusException;
class CustomExceptionHandler {
    use ApiResponse;
    public function register(Exceptions $exceptions): void {
        $exceptions->render(function (Throwable $e, $request): JsonResponse {
            return match (true) {
                $e instanceof TokenExpiredException => $this->errorResponse(
                    'Token expired',
                    null,
                    Response::HTTP_UNAUTHORIZED
                ),

                $e instanceof TokenInvalidException => $this->errorResponse(
                    'Token invalid',
                    null,
                    Response::HTTP_UNAUTHORIZED
                ),

                $e instanceof JWTException => $this->errorResponse(
                    'Token not provided',
                    null,
                    Response::HTTP_UNAUTHORIZED
                ),

                $e instanceof ValidationException => $this->errorResponse(
                    'Validation failed',
                    $e->errors(),
                    Response::HTTP_UNPROCESSABLE_ENTITY
                ),

                $e instanceof AuthenticationException => $this->errorResponse(
                    'Unauthenticated access',
                    null,
                    Response::HTTP_UNAUTHORIZED
                ),

                $e instanceof AuthorizationException => $this->errorResponse(
                    'This action is unauthorized',
                    null,
                    Response::HTTP_FORBIDDEN
                ),

                $e instanceof ModelNotFoundException,
                $e instanceof NotFoundHttpException => $this->errorResponse(
                    'Resource not found',
                    null,
                    Response::HTTP_NOT_FOUND
                ),

                $e instanceof HasHttpStatusException => $this->errorResponse(
                    $e->getMessage(),
                    null,
                    $e->statusCode()
                ),

                default => $this->errorResponse(
                    config('app.debug') ? $e->getMessage() : 'Internal server error',
                    config('app.debug') ? ['trace' => $e->getTraceAsString()] : null,
                    Response::HTTP_INTERNAL_SERVER_ERROR
                ),
            };
        });
    }
}