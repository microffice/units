<?php namespace Microffice\Units;

use Illuminate\Database\Eloquent\Model;

/**
 * Units
 *
 */ 

class Unit extends Model {

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

}