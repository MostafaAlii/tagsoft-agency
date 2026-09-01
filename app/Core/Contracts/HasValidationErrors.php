<?php
declare(strict_types=1);
namespace Core\Contracts;
interface HasValidationErrors {
    public function errors(): array;
}


