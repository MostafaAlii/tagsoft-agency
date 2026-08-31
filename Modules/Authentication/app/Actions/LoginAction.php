<?php

declare(strict_types=1);

namespace Authentication\Actions;

use Authentication\Dtos\LoginDTO;
use Authentication\Strategies\Contracts\AuthGuardStrategyInterface;
use Core\Actions\BaseAction;
use Illuminate\Validation\ValidationException;

final class LoginAction extends BaseAction
{
    public function execute(mixed ...$args): mixed
    {
        [$dto, $strategy] = $args;

        return $this->handle($dto, $strategy);
    }

    public function handle(LoginDTO $dto, AuthGuardStrategyInterface $strategy): array
    {
        $token = $strategy->attempt($dto->toArray());

        if (!$token) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $user = $strategy->user()?->load('profile');

        return [
            'user'         => $strategy->userResource($user),
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => $strategy->expiresIn(),
        ];
    }
}