<?php namespace Microffice\Units;

use Microffice\Core\Traits\EloquentModelResourceTrait;
use Microffice\Contracts\Units\UnitHandler as UnitContract;

/**
 * Unit Handler
 *
 */ 

class UnitHandler implements UnitContract {

    /**
     * Making this resource Validable.
     *
     */
    use EloquentModelResourceTrait;

    /**
     * First we set the namespaced default
     * Model name of the validable resource
     * handeled by this class.
     *
     */
    public function __construct()
    {
        $this->setModelName('UnitModel', __NAMESPACE__);
    }

    /**
    * Display a form to create a new Unit.
    *
    * @return Illuminate\View
    */
    public function create()
    {
        return view('units::units');
    }
    
    /**
    * Display a form to edit an existing Unit.
    *
    * @param int $id
    * @return Illuminate\View
    */
    public function edit($id)
    {
        $unit = UnitModel::find($id);
        /*return view('units::units')->with([
            'id' => $unit->id,
            'unit' => $unit->unit
            ]);/*/
        return view('units::units', $unit->toArray());
    }
}