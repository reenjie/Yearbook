<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Section;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class Instructor extends Controller
{
    
    public function index(){
        
     $data = User::where('id','!=',Auth::user()->id)->where('Role',1)->get();
      $section = Section::all();
      return view('Instructor.index',compact('data','section'));
    }

    public function store(Request $request){
        $email = $request->input('email');
        $firstname = $request->input('firstname');
        $middlename=$request->input('middlename');
        $lastname = $request->input('lastname');
        $role = $request->input('role');
        $section = $request->input('section');
        $batch = $request->input('batch');
        $student = $request->input('student');
       $password = $request->input('password');
       $sex = $request->input('sex');
       //Hash::make('password')
 
       $request->validate([
         'email'=>'required|unique:users',
       ]);
 
       if($batch == '' || $batch == null){
         $batch = 0;
       }
       if($section == '' || $section == null){
         $section = 0;
       }
       if($student == '' || $student == null){
         $student = null;
       }
 
       
 
     
       User::create([
         'Firstname'=>$firstname,
         'Middlename'=>$middlename,
         'Lastname'=>$lastname,
         'Sex'=>$sex,
         'Role'=>$role,
         'SectionID'=>$section,
         'BatchID' =>$batch,
         'StudentID'=>$student,
         'email' =>$email,
         'password'=>Hash::make($password),
       ]);
      
      return redirect()->route('instructor')->with('alert','New Instructor Added Successfully!');
      
     
 
        
 
     }
 
     public function edit(Request $request){
      
       
        $firstname = $request->input('firstname');
        $middlename=$request->input('middlename');
        $lastname = $request->input('lastname');
       $sex = $request->input('sex');
       $id = $request->input('id');
       $section = $request->input('section');
   
 
        if($section == ''){
        User::findorFail($id)->update([
         'Firstname'=>$firstname,
         'Middlename'=>$middlename,
         'Lastname'=>$lastname,
         'Sex'=>$sex,
       ]);
        }else {
          
    User::findorFail($id)->update([
         'Firstname'=>$firstname,
         'Middlename'=>$middlename,
         'Lastname'=>$lastname,
         'Sex'=>$sex,
         'SectionID'=>$section,
       ]);
        }
   return redirect()->route('instructor')->with('alert','Instructor Updated Successfully!');
      
 
     }
 
 
     public function destroy(Request $request){
       $id = $request->id;
       User::findorFail($id)->delete();
       return redirect()->route('instructor')->with('alert','Instructor Deleted Successfully!');
 
     }
}
