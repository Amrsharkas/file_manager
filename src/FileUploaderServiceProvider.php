<?php

namespace Emam\Filemanager;

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
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
        $this->loadMigrationsFrom(__DIR__ . 'database/migrations/2022_01_13_134811_create_file_permission_user_table.php');
        $this->loadViewsFrom(__DIR__ . '/views/fm','');
        $this->publishes([
            __DIR__ . '/views/fm' => base_path('resources/views/fm'),
        ]);
        $this->mergeConfigFrom(__DIR__ . '/config/service_configuration.php','service_configuration.php');
        $this->publishes([
            __DIR__ . '/views/fm' => base_path('resources/views/fm'),
            __DIR__ . '/config/service_configuration.php' => config_path('service_configuration.php'),
        ]);
        $this->publishes([
            __DIR__ . '/public/manager' => public_path('manager'),
        ], 'public');
        $this->publishes([
            __DIR__ . '\database/migrations/2022_01_13_134811_create_file_permission_user_table.php' =>base_path('database/migrations'),
        ], 'public');

        $this->publishes([
            __DIR__ . '\Http/Middleware/Fm/setRootPath.php' =>base_path('app/Http/Middleware/fm/setRootPath.php'),
        ], 'public');

//                $this->publishes([
//            __DIR__.'\Console/Commands/InstallAws.php' =>base_path('/Console/Commands/fm/InstallAws.php'),
//        ], 'public');
//        $this->publishes([
//            __DIR__.'\Console/Commands/RemoveExpirationFiles.php' =>base_path('/Console/Commands/fm/RemoveExpirationFiles.php'),
//        ], 'public');
    }
}
