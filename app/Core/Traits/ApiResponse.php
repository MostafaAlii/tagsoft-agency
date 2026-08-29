<?php

namespace Core\Traits;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

trait ApiResponse
{
    protected function successResponse(mixed $data = null, string $message = 'Operation successful', int $code = Response::HTTP_OK): JsonResponse
    {
        return response()->json(['status' => true, 'message' => $message, 'data' => $data], $code);
    }

    protected function errorResponse(string $message = 'An error occurred', mixed $errors = null, int $code = Response::HTTP_BAD_REQUEST): JsonResponse
    {
        return response()->json(['status' => false, 'message' => $message, 'errors' => $errors], $code);
    }

    protected function paginatedResponse(LengthAwarePaginator $paginator, mixed $resourceClass = null, string $message = 'Data retrieved successfully'): JsonResponse
    {
        $items = $resourceClass ? $resourceClass::collection($paginator->items()) : $paginator->items();

        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => $items,
            'meta' => [
                'current_page' => $paginator->currentPage(),
                'per_page' => $paginator->perPage(),
                'total' => $paginator->total(),
                'last_page' => $paginator->lastPage(),
                'has_more' => $paginator->hasMorePages(),
            ],
            'links' => [
                'first' => $paginator->url(1),
                'last' => $paginator->url($paginator->lastPage()),
                'prev' => $paginator->previousPageUrl(),
                'next' => $paginator->nextPageUrl(),
            ],
        ], Response::HTTP_OK);
    }
}
