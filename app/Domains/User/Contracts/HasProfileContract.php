<?php

declare(strict_types=1);

namespace Domains\User\Contracts;

interface HasProfileContract {
    public function profileModel(): string;
    public function profileForeignKey(): string;
}