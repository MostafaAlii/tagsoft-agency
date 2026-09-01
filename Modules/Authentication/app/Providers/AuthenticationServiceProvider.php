<?php
declare(strict_types=1);
namespace Authentication\Providers;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
class AuthenticationServiceProvider extends ServiceProvider {
    protected string $moduleName = 'Authentication';
    public function register(): void {
        $this->app->bind(
            \Authentication\Contracts\PasswordBrokerInterface::class,
            fn() => new \Authentication\Services\PasswordBroker(
                expireMinutes: (int) config('auth.passwords.admins.expire', 60),
                throttleSeconds: (int) config('auth.passwords.admins.throttle', 60),
            )
        );
        $this->app->bind(
            \Authentication\Contracts\PasswordManagerInterface::class,
            \Authentication\Services\PasswordManager::class
        );
    }

    public function boot(): void {
        $this->loadTranslationsFrom(module_path($this->moduleName, 'lang'),'authentication');
        $this->loadMigrationsFrom(module_path($this->moduleName, 'database/migrations'));
        Route::prefix('api')->middleware('api')->group(module_path($this->moduleName, 'routes/api.php'));
    }
}