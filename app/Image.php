<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
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
    
}
