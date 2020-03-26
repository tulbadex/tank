<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Tank;
use App\Location;

class Record extends Model
{
    protected $fillable = ['tank_id_from','tank_id_to', 'volume'];

    public function tank($id){

        //return $this->belongsTo('App\Tank');
        $tank_name = Tank::where('id',$id)->get();
        $tank_name = $tank_name[0]->name;

        $tank_location = Tank::where('id',$id)->get();
        $tank_location = $tank_location[0]->location_id;

        $tank_location = Location::where('id',$tank_location)->get();
        $tank_location = $tank_location[0]->name;

        return $tank_name." - ".$tank_location;
    }
    
    public function location($id){

        return $this->belongsTo('App\Location');
    }
}
