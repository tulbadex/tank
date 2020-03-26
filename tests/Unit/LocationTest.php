<?php

namespace Tests\Unit;

use App\Location;
use PHPUnit\Framework\TestCase;
//use Illuminate\Foundation\Testing\DatabaseMigrations;
//use Illuminate\Foundation\Testing\DatabaseTransacions;


class LocationTest extends TestCase
{
	//use DatabaseTransacions;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    /*public function testTakeOneFromLocation()
    {
    	$location = new Location(['sura', 'adeniji']);
    	$results = $location->startWith('s');
    	$this->assertCount(1, $results);
    }*/

    public function testLocationCount()
    {
    	
    	$location = new Location;
    	$location->setName('surs');
    	$this->assertEquals($location->getName(), 'surs');

    	/*$location = new Location;
    	$count = $location->getAllLocationCount();
    	$this->assertCount(2, $count);*/
    }

    public function testLocation()
    {
    	
    	$location = new Location;
    	$location->setName('surs');
    	$this->assertEquals($location->getName(), 'surs');

    }

    public function checkLocationDuplicate()
    {
    	$location = new Location(['location_one', 'location_two', 'location_three', 'location_one']);
    	$this->assertTrue($location->has('location_one'));
    	$this->assertFalse($location->has('location_four'));

    }
}
