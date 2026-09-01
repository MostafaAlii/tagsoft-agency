<?php

declare(strict_types=1);

namespace Authentication\Actions;

use Authentication\DTOs\ChangePasswordDTO;
use Authentication\Exceptions\{CurrentPasswordIncorrectException, PasswordPolicyException};
use Authentication\Strategies\Contracts\AuthGuardStrategyInterface;
use Core\Actions\BaseAction;
use Illuminate\Support\Facades\Hash;

final class ChangePasswordAction extends BaseAction
{
    public function execute(mixed ...$args): mixed
    {
        [$dto, $strategy] = $args;

        return $this->handle($dto, $strategy);
    }

    public function handle(ChangePasswordDTO $dto, AuthGuardStrategyInterface $strategy): void
    {
        $user = $strategy->user();

        if (!Hash::check($dto->currentPassword, $user->password)) {
            throw new CurrentPasswordIncorrectException();
        }

        $user->password = Hash::make($dto->newPassword);
        $user->save();
    }
}