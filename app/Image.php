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
    
    public function getImageUrl(){
        return asset("storage").'/'.$this->file_name;
    }
    
    public function issues(){
        $this->belongsTo(Issue::class);
    }
}
