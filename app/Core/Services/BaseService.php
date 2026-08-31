<?php

declare(strict_types=1);

namespace Core\Services;

use Closure;
use Illuminate\Support\Facades\{DB, Log};
use Throwable;

abstract class BaseService
{
    protected function transaction(Closure $callback, string $errorMessage = 'Transaction failed'): mixed
    {
        return $this->safeExecute(fn() => DB::transaction($callback), $errorMessage);
    }

    protected function safeExecute(Closure $callback, string $errorMessage = 'Service Error'): mixed
    {
        try {
            return $callback();
        } catch (Throwable $e) {
            Log::error("{$errorMessage}: " . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            throw $e;
        }
    }
}