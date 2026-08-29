<?php

namespace Core\Traits;

use Illuminate\Support\Facades\Cache;

trait Cacheable
{
    protected int $cacheTtl = 3600;

    protected function getCacheKey(string $identifier, array $params = []): string
    {
        $base = strtolower(str_replace('\\', '_', static::class));
        $paramString = !empty($params) ? '_' . md5(serialize($params)) : '';
        return "{$base}:{$identifier}{$paramString}";
    }

    protected function rememberCache(string $key, \Closure $callback, ?int $ttl = null): mixed
    {
        return Cache::remember($key, $ttl ?? $this->cacheTtl, $callback);
    }

    protected function forgetCache(string $key): bool
    {
        return Cache::forget($key);
    }
}