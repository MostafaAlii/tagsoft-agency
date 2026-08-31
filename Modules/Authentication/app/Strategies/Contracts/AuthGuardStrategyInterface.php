<?php

declare(strict_types=1);

namespace Authentication\Strategies\Contracts;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Resources\Json\JsonResource;

interface AuthGuardStrategyInterface
{
    public function guardName(): string;

    public function attempt(array $credentials): string|false;

    public function user(): ?Authenticatable;

    public function logout(): void;

    public function refresh(): string;

    public function expiresIn(): int;

    public function userResource(Authenticatable $user): JsonResource;
}