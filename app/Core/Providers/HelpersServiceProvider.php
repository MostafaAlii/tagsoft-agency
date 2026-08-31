<?php

namespace Core\Providers;

use Illuminate\Support\ServiceProvider;

class HelpersServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        // تسجيل جميع الـ Helper Files
        $this->loadHelpers();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        //
    }

    /**
     * Load all helper files from the Helpers directory.
     *
     * @return void
     */
    protected function loadHelpers(): void
    {
        $helpersPath = app_path('Core/Helpers');

        if (!is_dir($helpersPath)) {
            return;
        }

        // Load all PHP files in the Helpers directory
        foreach (glob($helpersPath . '/*.php') as $file) {
            $filename = basename($file);

            // Load helpers.php or any file that doesn't start with uppercase (not a class)
            if ($filename === 'helpers.php' || !preg_match('/^[A-Z]/', pathinfo($filename, PATHINFO_FILENAME))) {
                require_once $file;
            }
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides(): array
    {
        return [];
    }
}