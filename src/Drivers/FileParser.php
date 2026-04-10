<?php

namespace Nextpointer\CourierSync\Drivers;

use Maatwebsite\Excel\Facades\Excel;

class FileParser {
    public function parse($path, $type, $delimiter = ';') {
        if (strtolower($type) === 'csv') {
            return Excel::toArray([], $path, null, \Maatwebsite\Excel\Excel::CSV, [
                'delimiter' => $delimiter
            ])[0];
        }
        return Excel::toArray([], $path)[0];
    }
}