<?php

namespace Core\Services;

use Illuminate\Support\Facades\{DB,Log};
use Throwable;

abstract class BaseService
{
    protected function transaction(\Closure $callback): mixed
    {
        return DB::transaction($callback);
    }

    protected function safeExecute(\Closure $callback, string $errorMessage = 'Service Error'): mixed
    {
        try {
            return $callback();
        } catch (Throwable $e) {
            Log::error("{$errorMessage}: " . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            throw $e;
        }
    }
}
