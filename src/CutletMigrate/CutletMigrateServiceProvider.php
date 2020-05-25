<?php

namespace Va\CutletMigrate;

use Illuminate\Support\ServiceProvider;
use Va\CutletMigrate\Console\Commands\MigrateUpdate;

class CutletMigrateServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                MigrateUpdate::class
            ]);
        }

        $this->publishes([
            __DIR__ . '/../config/cutlet-migrate.php' => config_path('cutlet-migrate.php'),
        ], 'cutlet-migrate');

    }
}
