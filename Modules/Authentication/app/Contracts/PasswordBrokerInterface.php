<?php
declare(strict_types=1);
namespace Authentication\Contracts;
use Illuminate\Contracts\Auth\Authenticatable;
interface PasswordBrokerInterface {
    public function createToken(Authenticatable $user, string $guard): string;
    public function tokenExists(Authenticatable $user, string $guard, string $token): bool;
    public function deleteToken(Authenticatable $user, string $guard): void;
    public function recentlyCreatedToken(Authenticatable $user, string $guard): bool;
}