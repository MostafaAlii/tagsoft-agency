<?php
declare(strict_types=1);
namespace Authentication\Dtos;
use Core\DTOs\BaseDTO;
final readonly class LoginDTO extends BaseDTO {
    public function __construct(
        public string $email,
        public string $password,
    ) {}

    public static function fromArray(array $data): static {
        return new static(
            email: $data['email'],
            password: $data['password'],
        );
    }
}