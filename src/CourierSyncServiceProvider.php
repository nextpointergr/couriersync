<?php

namespace Nextpointer\CourierSync;

use Illuminate\Support\ServiceProvider;
// ΠΡΟΣΘΕΣΕ ΑΥΤΕΣ ΤΙΣ ΔΥΟ ΓΡΑΜΜΕΣ:
use Nextpointer\CourierSync\Models\CourierProvider;
use Nextpointer\CourierSync\Observers\CourierProviderObserver;

class CourierSyncServiceProvider extends ServiceProvider {
    public function boot() {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        // Τώρα η PHP ξέρει ποιες είναι αυτές οι κλάσεις
        CourierProvider::observe(CourierProviderObserver::class);
    }

    public function register() {
        $this->app->singleton('courier-sync', function () {
            return new CourierSyncManager();
        });
    }
}
