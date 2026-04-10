<?php

namespace Nextpointer\CourierSync;

use Nextpointer\CourierSync\Models\CourierProvider;
use Nextpointer\CourierSync\Drivers\FileParser;

class CourierSyncManager {
    public function process($slug, $filePath) {
        $provider = CourierProvider::where('slug', $slug)->firstOrFail();
        $rawData = (new FileParser())->parse($filePath, $provider->file_type, $provider->delimiter);

        // Φορτώνει την κλάση που δημιουργήθηκε αυτόματα
        $mapper = app($provider->map_class);

        return array_map(fn($row) => $mapper->map($row), $rawData);
    }
}