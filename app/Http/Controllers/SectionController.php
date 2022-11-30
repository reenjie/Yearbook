<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Section::all();
        return view('Section.index',compact('data'));
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
        Section::create([
            'Name'=>$name,
            'Description'=>$desc,
        ]);

        return redirect()->route('section')->with('alert','New Section Inserted Successfully!');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {   
        $id = $request->input('id');
        $name = $request->input('name');
        $desc = $request->input('description');

        Section::findorFail($id)->update([
            'Name'=>$name,
            'Description'=>$desc,
        ]);

        return redirect()->route('section')->with('alert','Section Updated Successfully!');
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        Section::findorFail($id)->delete();

        return redirect()->route('section')->with('alert','Selected Section Deleted Successfully!');

    }
}
