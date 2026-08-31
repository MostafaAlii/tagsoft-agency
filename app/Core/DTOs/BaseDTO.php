<?php

declare(strict_types=1);

namespace Core\DTOs;

use BackedEnum;

abstract readonly class BaseDTO
{
    abstract public static function fromArray(array $data): static;

    public function toArray(): array
    {
        return array_map(
            fn($value) => match (true) {
                $value instanceof BackedEnum => $value->value,
                $value instanceof self => $value->toArray(),
                default => $value,
            },
            get_object_vars($this)
        );
    }
}