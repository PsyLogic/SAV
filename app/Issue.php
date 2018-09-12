<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Issue extends Model
{
    use SoftDeletes;

    /**
     * Make all fiels assignable
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'delivered_at',
        'received_at',
        'closed_at',
        'deleted_at'
    ];
}
