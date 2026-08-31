<?php
declare(strict_types=1);
namespace Authentication\Providers;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
class AuthenticationServiceProvider extends ServiceProvider {
    protected string $moduleName = 'Authentication';
    public function register(): void {
        //
    }

    public function boot(): void {
        $this->loadMigrationsFrom(module_path($this->moduleName, 'database/migrations'));
        Route::prefix('api')->middleware('api')->group(module_path($this->moduleName, 'routes/api.php'));
    }
}