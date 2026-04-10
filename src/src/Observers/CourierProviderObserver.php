<?php

namespace Nextpointer\CourierSync\Observers;

use Nextpointer\CourierSync\Models\CourierProvider;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class CourierProviderObserver
{
    public function created(CourierProvider $provider)
    {
        $className = Str::studly($provider->slug) . 'Mapper';
        $directory = app_path('CourierMaps');

        // 1. Δημιουργία φακέλου αν δεν υπάρχει
        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        $path = "{$directory}/{$className}.php";

        // 2. Δημιουργία αρχείου μόνο αν δεν υπάρχει ήδη
        if (!File::exists($path)) {
            $stubPath = __DIR__ . '/../Mappers/stubs/courier-mapper.stub';
            $stub = File::get($stubPath);
            $content = str_replace('{{class}}', $className, $stub);

            File::put($path, $content);
        }

        // 3. Update τη βάση με το namespace της κλάσης
        $provider->updateQuietly([
            'map_class' => "App\\CourierMaps\\{$className}"
        ]);
    }
}