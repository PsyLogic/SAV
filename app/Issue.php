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

    /**
     * remove created_at and updated_at from table
     *
     * @var boolean
     */
    public $timestamps = false;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'client' => 'array',
    ];
    
    public function stage(){
        if($this->stage == 1)
            return '<span class="badge badge-pill badge-secondary">OPEN</span>';
        else if ($this->stage == 2)
            return '<span class="badge badge-pill badge-warning">IN PROCESS</span>';
        else
            return '<span class="badge badge-pill badge-success">Closed</span>';
    }

    

    public function commercial(){
        return $this->belongsTo(Commercial::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function problems(){
        return $this->belongsToMany(Problem::class);
    }
    public function solutions(){
        return $this->belongsToMany(Solution::class);
    }


}
