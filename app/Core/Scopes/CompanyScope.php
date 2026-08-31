<?php
declare(strict_types=1);
namespace Core\Scopes;
use Core\Enums\AdminTypeEnum;
use Illuminate\Database\Eloquent\{Builder, Model, Scope};
use Illuminate\Support\Facades\{Auth, Schema};

class CompanyScope implements Scope
{
    protected static array $hasCompanyColumnCache = [];

    public function apply(Builder $builder, Model $model): void
    {
        $table = $model->getTable();

        if (!array_key_exists($table, self::$hasCompanyColumnCache)) {
            self::$hasCompanyColumnCache[$table] = Schema::hasColumn($table, 'company_id');
        }

        if (!self::$hasCompanyColumnCache[$table]) {
            return;
        }

        $guard = get_current_guard();
        $user = $guard ? Auth::guard($guard)->user() : null;

        if (!$user) {
            return;
        }

        $userType = $user->type instanceof AdminTypeEnum
            ? $user->type
            : AdminTypeEnum::tryFrom($user->type ?? '');

        if ($userType?->isOwner()) {
            // Owner sees everything by default; optionally scope to one company
            // via an explicit request context (not a client-trusted header for regular users).
            if ($impersonatedCompanyId = request()->header('X-Company-ID')) {
                $builder->where("{$table}.company_id", $impersonatedCompanyId);
            }
            return;
        }

        if ($user->company_id) {
            $builder->where("{$table}.company_id", $user->company_id);
        } else {
            // No company_id and not an owner → should see nothing, not everything.
            $builder->whereRaw('1 = 0');
        }
    }
}