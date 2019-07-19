<?php

namespace erdemozveren\LaravelMacros\Facades;

use Illuminate\Support\Facades\Facade;

class LaravelMacros extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravelmacros';
    }
}
