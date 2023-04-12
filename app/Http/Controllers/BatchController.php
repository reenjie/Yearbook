<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\Excel;
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
        return view('Batch.index', compact('data'));
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
            'Name' => $name,
            'Description' => $desc,
            'Year' => $year,
        ]);
        return redirect()->route('batch')->with('alert', 'New Batch Inserted Successfully!');
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
            'Name' => $name,
            'Description' => $desc,
            'Year' => $year,
        ]);

        return redirect()->route('batch')->with('alert', 'Batch Updated Successfully!');
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
        return redirect()->route('batch')->with('alert', 'Batch Deleted Successfully!');
    }

    public function excelupload(Request $request)
    {
        $batch = $request->batch;
        $file  = $request->file('excellfile');
        $typeof = $request->typeof;

        $file->move(public_path('public/excel'),  $file->getClientOriginalName());

        $save = Excel::create([
            'file' => $file->getClientOriginalName(),
            'batch' => $batch,
            'typeof' => $typeof,
        ]);

        if ($save) {
            return redirect()->back()->with('alert', 'File saved Successfully!');
        }
    }

    public function destroyfile(Request $request)
    {
        $id = $request->id;

        $ex = Excel::findorFail($id);

        $filename = public_path('public/excel') . '/' . $ex->file;

        if (file_exists($filename)) {
            unlink($filename);
        }

        if ($ex->delete()) {
            return redirect()->back()->with('alert', 'File deleted Successfully!');
        }
    }
    
    public function download(Request $request){
       $filename = $request->filename;
    //   if($request->template){
    //          $path = public_path('../excel/template/').$filename;
    //   }else {
    //        $path = public_path('/excel/').$filename;
    //   }

    if($request->template){
                 $path = public_path('excel/template/').$filename;
          }else {
               $path = public_path('public/excel/').$filename;
     }
  

    if (!file_exists($path)) {
        abort(404);
    }
$headers = [
        'Content-Type' => 'application/octet-stream',
        'Content-Description' => 'File Transfer',
        'Content-Disposition' => 'attachment; filename="'.$filename.'"',
        'Content-Length' =>filesize($path),
        'Cache-Control' => 'private, max-age=0, must-revalidate',
        'Pragma' => 'public',
    ];

    
    return response()->download($path, $filename, $headers);
    }
}
