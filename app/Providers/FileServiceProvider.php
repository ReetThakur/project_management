<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Filesystem\FilesystemManager;

class FileServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('filesystem', function ($app) {
            return new FilesystemManager($app);
        });
    }

    public function boot()
    {
        // Register the local disk
        Storage::extend('local', function ($app, $config) {
            return Storage::createLocalDriver($config);
        });

        // Register the public disk
        Storage::extend('public', function ($app, $config) {
            return Storage::createPublicDriver($config);
        });
    }
} 