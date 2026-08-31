<?php
declare(strict_types=1);
namespace Authentication\Strategies;
use Core\Enums\AuthGuardEnum;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Resources\Json\JsonResource;
use Authentication\Http\Resources\EmployeeAuthResource;
final class EmployeeGuardStrategy extends AbstractJwtGuardStrategy {
    public function guardName(): string {
        return AuthGuardEnum::EMPLOYEE->value;
    }

    public function userResource(Authenticatable $user): JsonResource {
        return new EmployeeAuthResource($user);
    }
}