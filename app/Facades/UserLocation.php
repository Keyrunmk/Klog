<?php

namespace App\facades;

use App\Services\LocationService;

class UserLocation
{
    public static function resolveFacade($class)
    {
        return app()[$class];
    }

    public static function __callStatic($method, $arguments)
    {
        return self::resolveFacade(LocationService::class)->$method(...$arguments);
    }
}
