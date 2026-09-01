<?php

declare(strict_types=1);

namespace Authentication\DTOs;

use Core\DTOs\BaseDTO;

final readonly class ForgotPasswordDTO extends BaseDTO
{
    public function __construct(
        public string $email,
    ) {}

    public static function fromArray(array $data): static
    {
        return new static(email: $data['email']);
    }
}