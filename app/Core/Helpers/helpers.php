<?php

/**
 * Global helper functions for the application.
 */

use Core\Helpers\UuidHelper;
use Carbon\Carbon;

if (!function_exists('generate_uuid')) {
    /**
     * Generate a UUID v7.
     *
     * @return string
     */
    function generate_uuid(): string
    {
        return UuidHelper::generate();
    }
}

if (!function_exists('is_valid_uuid')) {
    /**
     * Validate a UUID.
     *
     * @param string $uuid
     * @return bool
     */
    function is_valid_uuid(string $uuid): bool
    {
        return UuidHelper::isValid($uuid);
    }
}

if (!function_exists('format_date')) {
    /**
     * Format a date.
     *
     * @param mixed $date
     * @param string $format
     * @return string|null
     */
    function format_date($date, string $format = 'Y-m-d H:i:s'): ?string
    {
        if (!$date) {
            return null;
        }

        return Carbon::parse($date)->format($format);
    }
}

if (!function_exists('get_current_guard')) {
    /**
     * Get the current guard.
     *
     * @return string|null
     */
    function get_current_guard(): ?string
    {
        $guards = ['admin', 'client', 'company', 'employee'];

        foreach ($guards as $guard) {
            if (auth()->guard($guard)->check()) {
                return $guard;
            }
        }

        return null;
    }
}

if (!function_exists('get_authenticated_user')) {
    /**
     * Get the authenticated user from any guard.
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    function get_authenticated_user()
    {
        $guards = ['admin', 'client', 'company', 'employee'];

        foreach ($guards as $guard) {
            if (auth()->guard($guard)->check()) {
                return auth()->guard($guard)->user();
            }
        }

        return null;
    }
}