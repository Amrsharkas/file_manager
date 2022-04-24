<?php

namespace Ie\FileManager;

use Illuminate\Support\ServiceProvider;

class FileUploaderServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadMigrationsFrom(__DIR__.'database/migrations/2022_01_13_134811_create_file_permission_user_table.php');
        $this->loadViewsFrom(__DIR__.'/views/fm','');
        $this->publishes([
            __DIR__.'/views/fm' => base_path('resources/views/fm'),
        ]);
        $this->mergeConfigFrom(__DIR__.'/config/service_configuration.php','service_configuration.php');
        $this->publishes([
            __DIR__.'/views/fm' => base_path('resources/views/fm'),
            __DIR__.'/config/service_configuration.php' => config_path('service_configuration.php'),
        ]);
        $this->publishes([
            __DIR__.'/public/manager' => public_path('manager'),
        ], 'public');
        $this->publishes([
            __DIR__.'\database/migrations/2022_01_13_134811_create_file_permission_user_table.php' =>base_path('database/migrations'),
        ], 'public');
    }
}
