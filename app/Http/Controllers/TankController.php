<?php

namespace App\Http\Controllers;

use App\Tank;
use App\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tanks = Tank::latest()->paginate(5);
        $locations = Location::orderBy('created_at', 'DESC')->get();
        return view('tank.index', compact('tanks', 'locations'))
        ->with('i', (request()->input('page',1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $query = \DB::table('tanks')
                ->select(DB::raw('count(*)'))
                ->where('name',$request->name)
                ->where('location_id',$request->location_id)
                ->count();

        //'name' => 'required|unique:tanks,name|max:255',


        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'volume' => 'required|numeric|min:1',
            'location_id' => 'required',
        ]);

        if ($query > 0) {
            return back()->with('error', 'Tank with same location already exist!');
        }

        try {
            Tank::create($validatedData);
            return redirect('/tanks')->with('success', 'Tank Created Successfully!');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tank  $tank
     * @return \Illuminate\Http\Response
     */
    public function show(Tank $tank)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tank  $tank
     * @return \Illuminate\Http\Response
     */
    public function edit(Tank $tank)
    {
        $locations = Location::orderBy('created_at', 'DESC')->get();

        return view('tank.edit', compact('tank', 'locations'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tank  $tank
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $tank = Tank::findOrFail($id);

        $query = \DB::table('tanks')
                ->select(DB::raw('count(*)'))
                ->where('name',$request->name)
                ->where('location_id',$request->location_id)
                ->where('id','!=',$id)
                ->count();

        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'volume' => 'required|numeric|min:1',
            'location_id' => 'required',
        ]);
        //|unique:tanks,name,location_id,'.$tank->id
        //$validatedData['updated_at'] = now();

        if ($query > 0) {
            return back()->with('error', 'Tank with same location already exist!');
        }

        if (!$tank) {
            throw new ModelNotFoundException('Data not available for edit');
        }

        try {
            $tank->update($validatedData);
            return redirect('/tanks')->with('success', 'Tank Updated Successfully!');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tank  $tank
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tank $tank)
    {
        $tank = Tank::findOrFail($tank->id);

        if (!$tank) {
            //return back()->with('error', 'Data not available for delete');
            throw new ModelNotFoundException('Data not available for delete');
        }

        try {
            $tank->delete();
            return redirect('/tanks')->with('success', 'Tank Deleted Successfully!');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
