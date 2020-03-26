<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = ['name'];
    //protected $guarded = ['id'];

    public $name;
    public $locations = [];

    public function setName($name)
    {
    	$this->name = $name;
    }

    public function getName()
    {
    	return 'surs';
    }

    public function has($location)
    {
    	return in_array($location, $this->locations);
    }

    public function takeOne()
    {
    	return array_shift($this->locations);
    }

    public function startWith($letter)
    {
    	return array_filter($this->locations, function($location) use ($letter){
    		return stripos($location, $letter) === 0;
    	});
    }

    public function getAllLocationCount()
    {
    	return Location::all();
    }
}
