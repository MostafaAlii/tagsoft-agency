<?php

declare(strict_types=1);

namespace Authentication\DTOs;

use Core\DTOs\BaseDTO;

final readonly class ResetPasswordDTO extends BaseDTO
{
    public function __construct(
        public string $email,
        public string $token,
        public string $password,
    ) {}

    public static function fromArray(array $data): static
    {
        return new static(
            email: $data['email'],
            token: $data['token'],
            password: $data['password'],
        );
    }
}