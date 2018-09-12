<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Problem extends Model
{
    use SoftDeletes;
    /**
     * Make all fiels assignable
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Disable timestamps from table
     *
     * @var boolean
     */
    public $timestamps = false;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];


}
