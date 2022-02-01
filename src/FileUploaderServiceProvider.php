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
        $this->loadMigrationsFrom(__DIR__.'/migrations');
        $this->loadViewsFrom(__DIR__.'/views','');
        $this->publishes([
            __DIR__.'/views' => base_path('resources/views'),
        ]);
        $this->mergeConfigFrom(__DIR__.'config/service_configuration.php','service_configuration');
        $this->publishes([
            __DIR__.'/views' => base_path('resources/views'),
            __DIR__.'config/service_configuration.php' => config_path('service_configuration'),
        ]);
        $this->publishes([
            __DIR__.'/public/manager' => public_path(),
        ], 'public');
    }
}
