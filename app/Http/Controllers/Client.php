<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Section;
use App\Models\Student;
use App\Models\Batch;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class Client extends Controller
{
    
    public function index(){
        $section = Section::all();
        $batch = Batch::all();
        $student = Student::all();
        $data = User::where('id','!=',Auth::user()->id)->where('Role',2)->get();
        return view('Client.index',compact('section','data','batch','student'));
    }
}
