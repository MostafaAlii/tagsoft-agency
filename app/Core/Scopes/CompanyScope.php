<?php
namespace Core\Scopes;
use Core\Enums\AdminTypeEnum;
use Illuminate\Database\Eloquent\{Builder,Model, Scope};
use Illuminate\Support\Facades\{Auth,Schema};
class CompanyScope implements Scope {
    public function apply(Builder $builder, Model $model): void {
        if (!Schema::hasColumn($model->getTable(), 'company_id')) {
            return;
        }

        $user = Auth::user();
        if (!$user) {
            return;
        }

        $userType = $user->type instanceof AdminTypeEnum
            ? $user->type
            : AdminTypeEnum::tryFrom($user->type ?? '');

        if ($userType?->isOwner() && is_null($user->company_id)) {
            return;
        }

        $companyId = $user->company_id ?? request()->header('X-Company-ID');
        if ($companyId) {
            $builder->where($model->getTable() . '.company_id', $companyId);
        }
    }
}
