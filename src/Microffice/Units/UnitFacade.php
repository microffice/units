<?php namespace Microffice\Units\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * UnitFacade
 *
 */ 
class Unit extends Facade {
 
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'unit'; }
 
}