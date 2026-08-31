<?php
declare(strict_types=1);
namespace Authentication\Strategies;
use Core\Enums\AuthGuardEnum;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Resources\Json\JsonResource;
use Authentication\Http\Resources\ClientAuthResource;
final class ClientGuardStrategy extends AbstractJwtGuardStrategy {
    public function guardName(): string {
        return AuthGuardEnum::CLIENT->value;
    }

    public function userResource(Authenticatable $user): JsonResource
    {
        return new ClientAuthResource($user);
    }
}