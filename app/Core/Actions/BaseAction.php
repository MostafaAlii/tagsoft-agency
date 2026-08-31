<?php

declare(strict_types=1);

namespace Core\Actions;

/**
 * Base class for all domain/module Actions.
 *
 * Actions may declare constructor dependencies (repositories, services) —
 * these are auto-resolved by the container via make().
 * Only pass runtime arguments to make(); dependencies resolve automatically.
 */
abstract class BaseAction
{
    abstract public function execute(mixed ...$args): mixed;

    public static function make(mixed ...$args): mixed
    {
        return app(static::class)->execute(...$args);
    }
}