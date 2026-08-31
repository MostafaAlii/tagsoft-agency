<?php

declare(strict_types=1);

namespace Core\Traits;

use Core\Helpers\UuidHelper;

trait HasUuid
{
    protected static function bootHasUuid(): void
    {
        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = UuidHelper::generate();
            }
        });
    }

    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where('uuid', $value)->firstOrFail();
    }

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }
}