<?php

declare(strict_types=1);
namespace Core\Traits;

use Core\Scopes\CompanyScope;
use Illuminate\Database\Eloquent\Builder;

trait HasCompanyScope
{
    /**
     * Boot the trait and attach the CompanyScope to the model.
     */
    protected static function bootHasCompanyScope(): void
    {
        static::addGlobalScope(new CompanyScope());
    }

    /**
     * Scope to bypass company filtering when needed (e.g., for Super Admin reports).
     */
    public function scopeWithoutCompany(Builder $query): Builder
    {
        return $query->withoutGlobalScope(CompanyScope::class);
    }
}