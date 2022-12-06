<?php

namespace App\Http\Controllers;
use App\Models\Section;
use App\Models\Batch;
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
}
