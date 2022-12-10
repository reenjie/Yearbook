<?php

namespace App\Http\Controllers;
use App\Models\Section;
use App\Models\Batch;
use App\Models\User;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class AllInstructorController extends Controller
{
    public function students(){
        $data = Student::where('SectionID',Auth::user()->SectionID)->get();
        $batch = Batch::all();
        $section = Section::all();
        return view('Students.index',compact('data','section','batch'));
    }

    public function confirmStudent(Request $request){
       $id = $request->id;
        Student::where('id',$id)->update([
            'diploma'=>1,
        ]);

        return redirect()->back();

    }

    public function confirmOrder(Request $request){
            $id = $request->userid;
            $type = $request->type;

            if($type == 'confirm'){
                User::where('id',$id)->update([
                    'status'=>2,
                ]);
            }else {
                User::where('id',$id)->update([
                    'status'=>1,
                ]);
            }
         
            return redirect()->back();
    }
}
