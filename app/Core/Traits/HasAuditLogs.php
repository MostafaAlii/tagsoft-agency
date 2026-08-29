<?php

namespace Core\Traits;

use Illuminate\Support\Facades\Auth;

trait HasAuditLogs
{
    protected static function bootHasAuditLogs(): void
    {
        static::creating(function ($model) {
            if (Auth::check()) {
                $user = Auth::user();
                if (in_array('created_by', $model->getFillable()) || isset($model->created_by)) {
                    $model->created_by = $user->id;
                    $model->created_by_guard = Auth::getDefaultDriver();
                }
            }
        });

        static::updating(function ($model) {
            if (Auth::check() && (in_array('updated_by', $model->getFillable()) || isset($model->updated_by))) {
                $model->updated_by = Auth::id();
                $model->updated_by_guard = Auth::getDefaultDriver();
            }
        });
    }
}
