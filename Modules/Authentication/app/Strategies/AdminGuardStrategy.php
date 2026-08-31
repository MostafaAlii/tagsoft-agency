<?php
declare(strict_types=1);
namespace Authentication\Strategies;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Resources\Json\JsonResource;
use Authentication\Http\Resources\AdminAuthResource;
use Core\Enums\AuthGuardEnum;
final class AdminGuardStrategy extends AbstractJwtGuardStrategy {
    public function guardName(): string {
        return AuthGuardEnum::ADMIN->value;
    }

    public function userResource(Authenticatable $user): JsonResource {
        return new AdminAuthResource($user);
    }
}