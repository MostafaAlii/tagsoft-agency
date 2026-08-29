<?php

namespace App\Core\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Schema;
/**
 * @mixin \Illuminate\Database\Eloquent\Model
 */
trait Filterable
{
    public function scopeFilter(Builder $query, array $filters = []): Builder
    {
        $filters = empty($filters) ? request()->all() : $filters;

        foreach ($filters as $field => $value) {
            if ($value === null || $value === '') continue;

            $method = 'scope' . ucfirst($field);
            if (method_exists($this, $method)) {
                $this->{$method}($query, $value);
                continue;
            }

            if ($field === 'company_id' && Schema::hasColumn($this->getTable(), 'company_id')) {
                $query->where($this->getTable() . '.company_id', $value);
                continue;
            }

            if (in_array($field, $this->fillable ?? [])) {
                $query->where($this->getTable() . '.' . $field, $value);
            }
        }
        return $query;
    }

    public function scopeSort(Builder $query, string $defaultSort = 'created_at', string $defaultDir = 'desc'): Builder
    {
        $sortBy = request()->query('sort_by', $defaultSort);
        $sortDir = strtolower(request()->query('sort_dir', $defaultDir)) === 'asc' ? 'asc' : 'desc';

        if (in_array($sortBy, $this->fillable ?? []) || $sortBy === $this->getKeyName()) {
            $query->orderBy($this->getTable() . '.' . $sortBy, $sortDir);
        }
        return $query;
    }
}