<?php

use App\Providers\AppServiceProvider;
use Core\Providers\HelpersServiceProvider;
use Domains\User\Providers\UserDomainServiceProvider;

return [
    AppServiceProvider::class,
    HelpersServiceProvider::class,
    UserDomainServiceProvider::class,
];