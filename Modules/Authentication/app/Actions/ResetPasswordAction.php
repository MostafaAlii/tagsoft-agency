<?php

declare(strict_types=1);

namespace Authentication\Actions;

use Authentication\Contracts\PasswordManagerInterface;
use Authentication\DTOs\ResetPasswordDTO;
use Core\Actions\BaseAction;

final class ResetPasswordAction extends BaseAction
{
    public function __construct(
        private readonly PasswordManagerInterface $manager,
    ) {}

    public function execute(mixed ...$args): mixed
    {
        [$dto, $guard] = $args;

        return $this->handle($dto, $guard);
    }

    public function handle(ResetPasswordDTO $dto, string $guard): void
    {
        $this->manager->reset($guard, $dto->email, $dto->token, $dto->password);
    }
}