<?php

namespace App\Http\Controllers;

use App\Models\Frontpage;
use App\Models\photos;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FrontpageController extends Controller
{

    public function savefpage(Request $request)
    {
        $addtype = $request->addtype;
        $attachfile = $request->file('attachfile');
        $message    = $request->message;
        $otherinfo  = $request->otherinfo;
        $title      = $request->title;
        $pagetype   = $request->pagetype;
        $fp = DB::Select('SELECT max(arrangement) as maxcount FROM `frontpages`');
        $count = 0;
        if ($fp[0]->maxcount >= 1) {
            $count = $fp[0]->maxcount + 1;
        } else {
            $count = 1;
        }
        if ($addtype == 'multiple') {
            if (count($attachfile) >= 1) {
                $add =
                    Frontpage::create([
                        'title' => $title,
                        'file' => "0x",
                        'message' => $message,
                        'otherinfo' => $otherinfo,
                        'arrangement' => $count,
                        'pagetype' => $pagetype
                    ]);
                foreach ($attachfile as $key => $file) {

                    $file->move(public_path('photos'), $file->getClientOriginalName());
                    photos::create([
                        'frontpageID' => $add->id,
                        'backpageID' => 0,
                        'file' => $file->getClientOriginalName()
                    ]);
                }
            }
        } else {
            if ($attachfile) {
                $attachfile->move(public_path('photos'), $attachfile->getClientOriginalName());
            }

            Frontpage::create([
                'title' => $title,
                'file' => $attachfile? $attachfile->getClientOriginalName() : null,
                'message' => $message,
                'otherinfo' => $otherinfo,
                'arrangement' => $count,
                'pagetype' => $pagetype
            ]);
        }

        return redirect()->back()->with('success', 'Page Added successfully!');
    }

    public function SaveEditFPage(Request $request){
        $title = $request->title;
        $addtype = $request->addtype;
        $otherinfo = $request->otherinfo;
        $message   = $request->message;
        $id        = $request->id;
        
        $fp = Frontpage::findorFail($id);
        if($request->file('attachfile')){
           
            if ($addtype == 'multiple') {
                if (count($request->file('attachfile')) >= 1) {
                    $edit =
                        $fp->update([
                            'title' => $title,
                            'file' => "0x",
                            'message' => $message,
                            'otherinfo' => $otherinfo,
                        ]);
                    foreach ($request->file('attachfile') as $key => $file) {
    
                        $filesrc = public_path('photos') . '/' . $fp->file;
                        if(file_exists($filesrc)){
                            unlink($filesrc);
                        }

          
                        $count = photos::where('frontpageID',$id);

                        if(count($count->get())>=1 ){
                            $file->move(public_path('photos'), $file->getClientOriginalName());
                            $count->update([
                                'file'=>$file->getClientOriginalName()
                            ]);
                        }else{
                            $file->move(public_path('photos'), $file->getClientOriginalName());
                            photos::create([
                            'frontpageID' => 0,
                            'backpageID' => $id,
                            'file' => $file->getClientOriginalName()
                        ]);
                        }
                    }
                }


            }else{
               
            $filesrc = public_path('photos'). '/' . $fp->file;
            if(file_exists($filesrc)){
                unlink($filesrc);
            }

            $fp -> update([
                'title' => $title,
                'file' => $request->file('attachfile')->getClientOriginalName(),
                'message' => $message,
                'otherinfo' => $otherinfo,
                'pagetype' => 'frontpage'
            ]);

            $request->file('attachfile')->move(public_path('photos'),$request->file('attachfile')->getClientOriginalName());



            }



        }else{
            $fp -> update([
                'title' => $title,
                'message' => $message,
                'otherinfo' => $otherinfo,     
                'pagetype' => 'frontpage'
            ]);
        }

      return redirect()->back()->with('success', 'Page Updated successfully!');
    }

    public function deletePages(Request $request)
    {
        $id = $request->id;
        $fp = Frontpage::findorFail($id);

        if ($fp->file) {
             $filesrc = public_path('photos') . '/' . $fp->file;
            if(file_exists($filesrc)){
                unlink($filesrc);
            }
            //    echo '<img src="'.$filesrc.'" />';
          
           
            
        }
        $fp->delete();
        $photos = photos::where('frontpageID', $id)->get();

        if (count($photos) >= 1) {

            foreach ($photos as $key => $value) {
                if ($value->file) {
                    unlink(public_path('photos') . '/' . $value->file);
                }
            }
        }
        return redirect()->back()->with('success', 'Page Deleted successfully!');
    }
}
