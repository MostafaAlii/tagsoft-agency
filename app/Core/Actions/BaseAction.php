<?php

namespace Core\Actions;

abstract class BaseAction
{
    abstract public function execute(mixed ...$args): mixed;

    public static function make(mixed ...$args): mixed
    {
        return app(static::class)->execute(...$args);
    }
}
