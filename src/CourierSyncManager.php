<?php

namespace Nextpointer\CourierSync;

use Nextpointer\CourierSync\Models\CourierProvider;
use Nextpointer\CourierSync\Models\CourierUpload;
use Nextpointer\CourierSync\Drivers\FileParser;

class CourierSyncManager {
    public function process($slug, $filePath) {
        $provider = CourierProvider::where('slug', $slug)->firstOrFail();

        // Δημιουργία εγγραφής στο ιστορικό
        $log = CourierUpload::create([
            'courier_provider_id' => $provider->id,
            'filename' => basename($filePath),
            'status' => 'processing'
        ]);

        try {
            $rawData = (new FileParser())->parse($filePath, $provider->file_type, $provider->delimiter);
            $mapper = app($provider->map_class);
            $processedData = array_map(fn($row) => $mapper->map($row), $rawData);
            $log->update([
                'status' => 'success',
                'total_rows' => count($processedData)
            ]);

            return $processedData;

        } catch (\Exception $e) {
            $log->update([
                'status' => 'failed',
                'error_message' => $e->getMessage()
            ]);
            throw $e;
        }
    }
}
