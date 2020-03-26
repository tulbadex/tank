<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tank extends Model
{
    protected $fillable = ['name','volume','location_id'];

    public function location(){

        return $this->belongsTo('App\Location');
    }
}
