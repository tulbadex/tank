<?php

namespace App\Http\Controllers;

use App\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $locations = Location::latest()->paginate(5);
        return view('location.index', compact('locations'))
        ->with('i', (request()->input('page',1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|unique:locations|max:255',
        ]);

        try {
            Location::create($validatedData);
        } catch (Exception $e) {
             return back()->with('error', $e->getMessage());
        }

        return redirect('/locations')->with('success', 'Location Created Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function show(Location $location)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function edit(Location $location)
    {
        return view('location.edit', compact('location'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Location $location)
    {
        $location = Location::findOrFail($location->id);

        $validatedData = $request->validate([
            'name' => 'required|max:255|unique:locations,name,'.$location->id,
        ]);

        if (!$location) {
            throw new ModelNotFoundException('Data not available for edit');
        }

        try {
            $location->update($validatedData);
            return redirect('/locations')->with('success', 'Location Updated Successfully!');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function destroy(Location $location)
    {
        $location = Location::findOrFail($location->id);

        if (!$location) {
            throw new ModelNotFoundException('Data not available for delete');
        }

        try {
            $location->delete();
            return redirect('/locations')->with('success', 'Location Deleted Successfully!');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
