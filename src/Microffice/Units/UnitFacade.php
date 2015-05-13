<?php namespace Microffice\Units;

use Illuminate\Support\Facades\Facade;

/**
 * UnitFacade
 *
 */ 
class UnitFacade extends Facade {
 
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'unit'; }
 
}