<?php

declare(strict_types=1);

namespace Domains\User\Observers;

use Domains\User\Contracts\HasProfileContract;
use Domains\User\Factories\ProfileFactory;

final class CreateProfileObserver
{
    public function created(HasProfileContract $model): void
    {
        ProfileFactory::makeFor($model);
    }

    public function deleted(HasProfileContract $model): void
    {
        $model->profile?->delete();
    }
}