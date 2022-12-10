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

         $bg = Batch::findorFail($wb[0]['BatchID'])->bg;
         $batches = Batch::where('id',$wb[0]['BatchID'])->get();

        
         if($bg == null){
            $batchbg = 'https://img.freepik.com/free-vector/graduation-greeting-card_53876-89341.jpg?w=740&t=st=1670294908~exp=1670295508~hmac=6c5367105b93ffc370a6892b37d896d56e197c259ca13639505361ca43d33aaa';
         }else {
            $batchbg = asset('photos').'/'.$bg;
         }
          
         $otherbatch = DB::select('select * from batches where id != '.$wb[0]['BatchID'].' ');
      
   return view('Yearbook.index',compact('section','student','user','batchbg','otherbatch','batches'));
    }

    public function changebatch(Request $request){
       $id = $request->id;

       $section = DB::select('select * from sections where id in (select SectionID from students where BatchID ='.$id.')');
       $user = User::where('Role',1)->get();
       $student = Student::where('BatchID',$id)->get();

    $bg = Batch::findorFail($id)->bg;
    $batches = Batch::where('id',$id)->get();
    if($bg == null){
       $batchbg = 'https://img.freepik.com/free-vector/graduation-greeting-card_53876-89341.jpg?w=740&t=st=1670294908~exp=1670295508~hmac=6c5367105b93ffc370a6892b37d896d56e197c259ca13639505361ca43d33aaa';
    }else {
       $batchbg = asset('photos').'/'.$bg;
    }
     
 
 
return view('Yearbook.index',compact('section','student','user','batchbg','batches'));
    }
}
