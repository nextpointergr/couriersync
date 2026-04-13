<?php

namespace Nextpointer\CourierSync\Observers;

use Nextpointer\CourierSync\Models\CourierProvider;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class CourierProviderObserver {
    public function created(CourierProvider $provider) {
        $className = Str::studly($provider->slug) . 'Mapper';
        $directory = app_path('CourierMaps');

        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        $path = "{$directory}/{$className}.php";

        if (!File::exists($path)) {
            $stub = File::get(__DIR__ . '/../Mappers/stubs/courier-mapper.stub');
            $content = str_replace('{{class}}', $className, $stub);
            File::put($path, $content);
        }
        $provider->updateQuietly(['map_class' => "App\\CourierMaps\\{$className}"]);
    }
}
