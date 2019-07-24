<?php

namespace erdemozveren\laravelmacros\Facades;

use Illuminate\Support\Facades\Facade;

class laravelmacros extends Facade
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
