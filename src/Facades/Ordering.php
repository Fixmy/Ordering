<?php

namespace Fixme\Ordering\Facades;

use Illuminate\Support\Facades\Facade;

class Ordering extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'ordering';
    }
}
