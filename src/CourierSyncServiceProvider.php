<?php

namespace Nextpointer\CourierSync;

use Illuminate\Support\ServiceProvider;
use Nextpointer\CourierSync\Models\CourierProvider;
use Nextpointer\CourierSync\Observers\CourierProviderObserver;

class CourierSyncServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Φορτώνουμε τα migrations
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        // Ενεργοποιούμε τον Observer
        CourierProvider::observe(CourierProviderObserver::class);

        // Publish το config
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/courier-sync.php' => config_path('courier-sync.php'),
            ], 'config');
        }
    }

    public function register()
    {
        $this->app->singleton('courier-sync', function () {
            return new CourierSyncManager();
        });
    }
}