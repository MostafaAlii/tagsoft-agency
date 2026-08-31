<?php

declare(strict_types=1);

namespace Authentication\Actions;

use Authentication\Strategies\Contracts\AuthGuardStrategyInterface;
use Core\Actions\BaseAction;
use Illuminate\Http\Resources\Json\JsonResource;

final class MeAction extends BaseAction
{
    public function execute(mixed ...$args): mixed
    {
        [$strategy] = $args;

        return $this->handle($strategy);
    }

    public function handle(AuthGuardStrategyInterface $strategy): ?JsonResource
    {
        $user = $strategy->user()?->load('profile');

        if (!$user) {
            return null;
        }

        return $strategy->userResource($user);
    }
}