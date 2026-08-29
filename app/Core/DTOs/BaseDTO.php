<?php

namespace Core\DTOs;

abstract readonly class BaseDTO
{
    abstract public static function fromRequest(mixed $request): static;

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
