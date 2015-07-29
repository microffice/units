<?php namespace Microffice\Support\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Unit Facade
 *
 */ 
class Unit extends Facade {
 
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    //protected static function getFacadeAccessor() { return 'Microffice\Contracts\Units\UnitHandler'; }
    protected static function getFacadeAccessor() { return 'unit'; }
 
}