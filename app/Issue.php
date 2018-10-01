<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

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
        'delivered_at' => 'date:d-m-Y',
        'received_at' => 'date:d-m-Y',
        'closed_at' => 'date:d-m-Y',
        'deleted_at' => 'date:d-m-Y',
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

    public function french_format($date){
        return Carbon::parse($date)->format('d-m-Y');
    }

    public function imagesBefore(){
        return $this->hasMany(Image::class)->where('status','before');
    }

    public function imagesAfter(){
        return $this->hasMany(Image::class)->where('status','after');
    }
    
    public function getFeesDHAttribute(){
        return $this->charges . ' DH';
    }


}
