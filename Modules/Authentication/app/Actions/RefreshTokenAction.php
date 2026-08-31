<?php
declare(strict_types=1);

namespace Authentication\Actions;

use Core\Actions\BaseAction;
use Authentication\Strategies\Contracts\AuthGuardStrategyInterface;
final class RefreshTokenAction extends BaseAction {
    public function execute(mixed ...$args): mixed {
        [$strategy] = $args;
        return $this->handle($strategy);
    }

    public function handle(AuthGuardStrategyInterface $strategy): array {
        $token = $strategy->refresh();
        return [
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => $strategy->expiresIn(),
        ];
    }
}