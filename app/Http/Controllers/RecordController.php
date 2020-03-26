<?php

namespace App\Http\Controllers;

use App\Record;
use App\Tank;
use Illuminate\Http\Request;

class RecordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$records = Record::latest()->paginate(5);
        $records = Record::latest()->paginate(5);
        $tanks = Tank::orderBy('created_at', 'DESC')->get();
        return view('record.index', compact('records', 'tanks'))
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
        $validatedData = $request->validate([
            'tank_id_from' => 'required',
            'tank_id_to' => 'required',
            'volume' => 'required|min:1|numeric',
        ]);

        if ($request->tank_id_from == $request->tank_id_to) {
            return back()->with('error', 'You can not tranfer to same tank!');
        }

        $tank_from = Tank::where('id', $request->tank_id_from)->get();
        $tank_to = Tank::where('id', $request->tank_id_to)->get();
        
        if ($tank_from[0]->volume <= 0 && $request->volume > $tank_from[0]->volume) {
            return back()->with('error', 'Tank volume is lesser than transfer volume!');
        }

        /*if (($tank_from[0]->volume - $request->volume) == 0) {
            return back()->with('error', 'Tank volume can not be 0!');
        }*/

        $remain_volume = $tank_from[0]->volume - $request->volume;
        $added_volume = $request->volume + $tank_to[0]->volume;

        try {
            Record::create($validatedData);
            $tank_update = Tank::find($request->tank_id_from);
            $tank_update->volume = $remain_volume;
            $tank_update->save();

            $tank_update = Tank::find($request->tank_id_to);
            $tank_update->volume = $added_volume;
            $tank_update->save();
            return redirect('/transfers')->with('success', 'Tank volume tranfer Successfully!');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Record  $record
     * @return \Illuminate\Http\Response
     */
    public function show(Record $record)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Record  $record
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tanks = Tank::orderBy('created_at', 'DESC')->get();
        $record = Record::findOrFail($id);
        return view('record.edit', compact('record','tanks'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Record  $record
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $record = Record::findOrFail($id);

        $validatedData = $request->validate([
            'tank_id_from' => 'required',
            'tank_id_to' => 'required',
            'volume' => 'required|min:1|numeric',
        ]);

        if ($request->tank_id_from == $request->tank_id_to) {
            return back()->with('error', 'You can not tranfer to same tank!');
        }

        $tank_from = Tank::where('id', $request->tank_id_from)->get();
        $tank_to = Tank::where('id', $request->tank_id_to)->get();
        
        if ($tank_from[0]->volume <= 0 && $request->volume > $tank_from[0]->volume) {
            return back()->with('error', 'Tank volume is lesser than transfer volume!');
        }

        /*if (($tank_from[0]->volume - $request->volume) == 0) {
            return back()->with('error', 'Tank volume can not be 0!');
        }*/

        $remain_volume = $added_volume = $record_volume = '';

        $record_details = Record::where('id', $id)->get();
        //$tank_to = Tank::where('id', $request->tank_id_to)->get();

        if ($tank_from[0]->id == $request->tank_id_from && $tank_from[0]->volume == $request->volume) {
            $remain_volume = $tank_from[0]->volume;
            $added_volume = $tank_to[0]->volume;
        }else{
            $record_volume = $record_details[0]->volume;
            $record_from = $record_details[0]->tank_id_from;
            $record_to = $record_details[0]->tank_id_to;

            //add back to previous tank
            $tank_return_update = Tank::find($record_from);
            $return_previous_volume = $tank_return_update->volume + $record_volume;
            $tank_return_update->volume = $return_previous_volume;
            //dd($tank_return_update->volume);
            $tank_return_update->save();

            //remove from previous added tank
            $tank_remove_update = Tank::find($record_to);
            $return_previous_volume = $tank_remove_update->volume - $record_volume;
            $tank_remove_update->volume = $return_previous_volume;
            $tank_remove_update->save();

            $remain_volume = Tank::find($request->tank_id_from);
            $remain_volume = $remain_volume->volume - $request->volume;

            $added_volume = Tank::find($request->tank_id_to);
            $added_volume = $added_volume->volume + $request->volume;
        }

        

        try {
            $record->update($validatedData);

            $tank_update = Tank::find($request->tank_id_from);
            $tank_update->volume = $remain_volume;
            $tank_update->save();

            $tank_update = Tank::find($request->tank_id_to);
            $tank_update->volume = $added_volume;
            $tank_update->save();
            return redirect('/transfers')->with('success', 'Tank volume tranfer updated Successfully!');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Record  $record
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //dd($record); Record $record
        $record = Record::findOrFail($id);

        if (!$record) {
            throw new ModelNotFoundException('Data not available for delete');
        }

        try {
            $record->delete();
            return redirect('/transfers')->with('success', 'Record Deleted Successfully!');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
