<?php

declare(strict_types=1);

namespace Domains\User\Providers;

use Domains\User\Models\{Admin,Client,Employee};
use Domains\User\Observers\CreateProfileObserver;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\ServiceProvider;

class UserDomainServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $this->loadMigrationsFrom(app_path('Domains/User/Database/Migrations'));
        $this->registerFactories();
        $this->registerObservers();
    }
    
    protected function registerFactories(): void {
        Factory::guessFactoryNamesUsing(
            fn(string $modelName) => 'Domains\\User\\Database\\Factories\\' . class_basename($modelName) . 'Factory'
        );
    }

    protected function registerObservers(): void
    {
        Admin::observe(CreateProfileObserver::class);
        Client::observe(CreateProfileObserver::class);
        Employee::observe(CreateProfileObserver::class);
    }
}