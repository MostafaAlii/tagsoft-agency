<?php

namespace Core\Helpers;

use Illuminate\Support\Str;
use Carbon\Carbon;

/**
 * Class UuidHelper
 * 
 * Provides UUID generation and validation functionality.
 * Uses UUID v7 (time-ordered) for better database performance.
 */
class UuidHelper
{
    /**
     * Generate a UUID v7 (time-ordered).
     *
     * @return string
     */
    public static function generate(): string
    {
        return (string) Str::uuid7();
    }

    /**
     * Generate a UUID v4 (random - fallback).
     *
     * @return string
     */
    public static function generateV4(): string
    {
        return (string) Str::uuid();
    }

    /**
     * Validate a UUID (supports v4, v6, v7).
     *
     * @param string $uuid
     * @return bool
     */
    public static function isValid(string $uuid): bool
    {
        return Str::isUuid($uuid);
    }

    /**
     * Generate a UUID v7 without dashes.
     *
     * @return string
     */
    public static function generateWithoutDashes(): string
    {
        return str_replace('-', '', self::generate());
    }

    /**
     * Extract timestamp from UUID v7.
     *
     * @param string $uuid
     * @return \DateTimeInterface|null
     */
    public static function extractTimestamp(string $uuid): ?\DateTimeInterface
    {
        if (!self::isValid($uuid)) {
            return null;
        }

        $hex = str_replace('-', '', $uuid);
        $timestampHex = substr($hex, 0, 12);
        $timestampMs = hexdec($timestampHex);

        return Carbon::createFromTimestampMs($timestampMs);
    }

    /**
     * Check if UUID is v7.
     *
     * @param string $uuid
     * @return bool
     */
    public static function isV7(string $uuid): bool
    {
        if (!self::isValid($uuid)) {
            return false;
        }

        $version = hexdec(substr($uuid, 14, 1));
        return $version === 7;
    }

    /**
     * Check if UUID is v4.
     *
     * @param string $uuid
     * @return bool
     */
    public static function isV4(string $uuid): bool
    {
        if (!self::isValid($uuid)) {
            return false;
        }

        $version = hexdec(substr($uuid, 14, 1));
        return $version === 4;
    }
}