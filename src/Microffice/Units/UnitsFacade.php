<?php

namespace Microffice\Units;

use Illuminate\Support\Facades\Facade;

/**
 * UnitsFacade
 *
 */ 
class UnitsFacade extends Facade {
 
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'units'; }
 
}