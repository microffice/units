<?php namespace Microffice\Units;

use Illuminate\Database\Eloquent\Model;

/**
 * Units Model
 *
 */ 

class UnitModel extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'units';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['unit'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * Indicates if te model should be timestamped
     *
     * @var bool
     */
    public $timestamps = true;
 
    /**
    * Validation Rules
    * this is just a place for us to store these, you could
    * alternatively place them in your repository
    * @var array
    */
    public static $rules = array(
        'unit' => 'required|min:1|max:5'
    );

}