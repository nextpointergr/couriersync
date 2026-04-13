<?php

namespace Nextpointer\CourierSync\Facades;

use Illuminate\Support\Facades\Facade;

class CourierSync extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'courier-sync';
    }
}