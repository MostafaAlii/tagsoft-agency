<?php
declare(strict_types=1);
namespace Authentication\Actions;
use Core\Actions\BaseAction;
use Authentication\Strategies\Contracts\AuthGuardStrategyInterface;
final class LogoutAction extends BaseAction {
    public function execute(mixed ...$args): mixed {
        [$strategy] = $args;
        return $this->handle($strategy);
    }

    public function handle(AuthGuardStrategyInterface $strategy): void {
        $strategy->logout();
    }
}