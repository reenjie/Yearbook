<?php

namespace App\Http\Controllers;
use App\Models\Section;
use App\Models\Batch;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AllClientsController extends Controller
{
    public function yearbook(){
            $studID = Auth::user()->StudentID;
            $wb = Student::where('id',$studID)->get();
            $section = DB::select('select * from sections where id in (select SectionID from students where BatchID ='.$wb[0]['BatchID'].')');
            $user = User::where('Role',1)->get();
            $student = Student::where('BatchID',$wb[0]['BatchID'])->get();
    return view('Yearbook.index',compact('section','student','user'));
    }
}
