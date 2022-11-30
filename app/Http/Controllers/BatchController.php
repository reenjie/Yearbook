<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use Illuminate\Http\Request;

class BatchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = Batch::all();
        return view('Batch.index',compact('data'));
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
       $name = $request->input('name');
       $desc = $request->input('description');
       $year = $request->input('year');

       Batch::create([
        'Name'=>$name,
        'Description'=>$desc,
        'Year'=>$year,
       ]);
       return redirect()->route('batch')->with('alert','New Batch Inserted Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Batch  $batch
     * @return \Illuminate\Http\Response
     */
    public function show(Batch $batch)
    {
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Batch  $batch
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {   
        $id = $request->input('id');
        $name = $request->input('name');
        $desc = $request->input('description');
        $year = $request->input('year');

        Batch::findorFail($id)->update([
        'Name'=>$name,
        'Description'=>$desc,
        'Year'=>$year,
        ]);

        return redirect()->route('batch')->with('alert','Batch Updated Successfully!');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Batch  $batch
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Batch $batch)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Batch  $batch
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->id;

        Batch::findorFail($id)->delete();
        return redirect()->route('batch')->with('alert','Batch Deleted Successfully!');

    }
}
