<?php

namespace Nextpointer\CourierSync;

use Illuminate\Support\ServiceProvider;

class CourierSyncServiceProvider extends ServiceProvider {
    public function boot() {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        // Χρησιμοποιούμε το class_exists για να αποφύγουμε το crash κατά το discovery
        if (class_exists('Nextpointer\CourierSync\Models\CourierProvider')) {
            \Nextpointer\CourierSync\Models\CourierProvider::observe(
                \Nextpointer\CourierSync\Observers\CourierProviderObserver::class
            );
        }
    }

    public function register() {
        $this->app->singleton('courier-sync', function () {
            return new CourierSyncManager();
        });
    }
}
