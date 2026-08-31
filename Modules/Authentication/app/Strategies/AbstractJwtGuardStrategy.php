<?php
declare(strict_types=1);
namespace Authentication\Strategies;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;
use Authentication\Strategies\Contracts\AuthGuardStrategyInterface;

abstract class AbstractJwtGuardStrategy implements AuthGuardStrategyInterface {
    public function attempt(array $credentials): string|false {
        return Auth::guard($this->guardName())->attempt($credentials);
    }

    public function user(): ?Authenticatable {
        return Auth::guard($this->guardName())->user();
    }

    public function logout(): void {
        Auth::guard($this->guardName())->logout();
    }

    public function refresh(): string {
        return Auth::guard($this->guardName())->refresh();
    }

    public function expiresIn(): int {
        return (int) config('jwt.ttl') * 60;
    }
}