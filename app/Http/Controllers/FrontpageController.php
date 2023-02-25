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
                        'pagetype' => 'frontpage'
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
                'file' => $attachfile->getClientOriginalName(),
                'message' => $message,
                'otherinfo' => $otherinfo,
                'arrangement' => $count,
                'pagetype' => 'frontpage'
            ]);
        }

        return redirect()->back()->with('success', 'Page Added successfully!');
    }

    public function deletePages(Request $request)
    {
        $id = $request->id;
        $fp = Frontpage::findorFail($id);

        if ($fp->file) {
            unlink(asset('photos') . '/' . $fp->file);
        }
        $fp->delete();
        $photos = photos::where('frontpageID', $id)->get();

        if (count($photos) >= 1) {

            foreach ($photos as $key => $value) {
                if ($value->file) {
                    unlink(asset('photos') . '/' . $value->file);
                }
            }
        }
        return redirect()->back()->with('success', 'Page Deleted successfully!');
    }
}
