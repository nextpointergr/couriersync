<?php

namespace Nextpointer\CourierSync\Contracts;

interface CourierMapper {
    /**
     * Μετατρέπει μια "ακατέργαστη" γραμμή του αρχείου σε standard array.
     */
    public function map(array $row): array;
}