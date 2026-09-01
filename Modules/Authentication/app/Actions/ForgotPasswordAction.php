<?php

declare(strict_types=1);

namespace Authentication\Actions;

use Authentication\Contracts\PasswordManagerInterface;
use Authentication\DTOs\ForgotPasswordDTO;
use Core\Actions\BaseAction;

final class ForgotPasswordAction extends BaseAction
{
    public function __construct(
        private readonly PasswordManagerInterface $manager,
    ) {}

    public function execute(mixed ...$args): mixed
    {
        [$dto, $guard] = $args;

        return $this->handle($dto, $guard);
    }

    public function handle(ForgotPasswordDTO $dto, string $guard): void
    {
        $this->manager->sendResetLink($guard, $dto->email);
    }
}