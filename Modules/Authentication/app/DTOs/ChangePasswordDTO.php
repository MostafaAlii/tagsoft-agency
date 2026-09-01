<?php

declare(strict_types=1);

namespace Authentication\DTOs;

use Core\DTOs\BaseDTO;

final readonly class ChangePasswordDTO extends BaseDTO
{
    public function __construct(
        public string $currentPassword,
        public string $newPassword,
    ) {}

    public static function fromArray(array $data): static
    {
        return new static(
            currentPassword: $data['current_password'],
            newPassword: $data['new_password'],
        );
    }
}