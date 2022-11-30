<?php

namespace App\Http\Controllers;
use App\Models\Section;
use App\Models\Batch;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Book extends Controller
{
    public function index(){
        $batch = Batch::all();
        $section = Section::all();
        $student = Student::all();
        return view('book.index',compact('batch','section','student'));
    }

    public function StoreStudent(){
        $batch = Batch::all();
        $section = Section::all();
        return view('book.Addstudent',compact('batch','section'));

    }

    public function store(Request $request){
        $firstname = $request->input('firstname');
        $middlename = $request->input('middlename');
        $lastname = $request->input('lastname');
        $sex = $request->input('sex');
        $birthdate = $request->input('birthdate');
        $address = $request->input('address');
        $section = $request->input('section');
        $batch = $request->input('batch');
        $honors = $request->input('honors');

        if($request->file('photo')){
            $imageName = time().'.'.$request->file('photo')->getClientOriginalExtension();
         
           $request->file('photo')->move(public_path('photos'), $imageName);

           Student::create([
            'Firstname'=>$firstname,
            'Middlename'=>$middlename,
            'Lastname'=>$lastname,
            'Sex'=>$sex,
            'Birthdate'=>$birthdate,
            'Address'=>$address,
            'Honors'=>$honors,
            'SectionID'=>$section,
            'BatchID'=>$batch,
            'photo'=>$imageName,
           ]);


           $batch = Batch::all();
        $section = Section::all();
        $student = Student::all();

        return redirect()->route('books')->with('alert','New Student Added Successfully!');

  
    
          }

         
    }

    public function fetchstudent(Request $request){
        $searchquery = $request->search;


        if($searchquery){

            if(!empty($searchquery['value']) && !empty($searchquery['batch']) && !empty($searchquery['section']) ){
                
                //search for all

                $data =  DB::select("SELECT * FROM `students` WHERE Firstname like '%".$searchquery['value']."%' or Middlename like '%".$searchquery['value']."%' or Lastname like '%".$searchquery['value']."%' and SectionID like '%".$searchquery['section']."%'  and BatchID like '%".$searchquery['batch']."%'  ");


            }else 
            if(empty($searchquery['value']) && !empty($searchquery['batch']) && empty($searchquery['section'])){
               
               //search for batch
                $data =  DB::select("SELECT * FROM `students` WHERE  BatchID ='".$searchquery['batch']."'  ");

            }else if(empty($searchquery['value']) && empty($searchquery['batch']) && !empty($searchquery['section'])){
                //search for section

                $data =  DB::select("SELECT * FROM `students` WHERE  SectionID ='".$searchquery['section']."'  ");
             
            }else if (!empty($searchquery['value']) && empty($searchquery['batch']) && empty($searchquery['section'])){
                //search for value

                $data =  DB::select("SELECT * FROM `students` WHERE Firstname like '%".$searchquery['value']."%' or Middlename like '%".$searchquery['value']."%' or Lastname like '%".$searchquery['value']."%' ");

               
            }else if (empty($searchquery['value']) && !empty($searchquery['batch']) && !empty($searchquery['section'])){
                //search for batch & section 

                $data =  DB::select("SELECT * FROM `students` WHERE  SectionID like '%".$searchquery['section']."%'  and BatchID like '%".$searchquery['batch']."%'  ");
                
            }else if (!empty($searchquery['value']) && !empty($searchquery['batch']) && empty($searchquery['section'])){

                //search for value and batch
                $data =  DB::select("SELECT * FROM `students` WHERE Firstname like '%".$searchquery['value']."%' or Middlename like '%".$searchquery['value']."%' or Lastname like '%".$searchquery['value']."%' and BatchID like '%".$searchquery['batch']."%'  ");

              
            }else if (!empty($searchquery['value']) && empty($searchquery['batch']) && !empty($searchquery['section'])){
                //search for value and section 

                $data =  DB::select("SELECT * FROM `students` WHERE Firstname like '%".$searchquery['value']."%' or Middlename like '%".$searchquery['value']."%' or Lastname like '%".$searchquery['value']."%' and SectionID like '%".$searchquery['section']."%'   ");
              
            }else {
                $data =  Student::all();
            }
            
          
           
  
        }else {
            $data =  Student::all();
        }

          
        
        foreach ($data as $key => $row) {
            echo '
            <div class="col-md-3 d-flex align-items-stretch">
            <div class="card bg-light shadow-lg">
                <div class="card-header">
                
                
              <img src="'.asset("photos")."/".$row->photo.'" style="width: 100%;height:200px" alt="">
                </div>
                <div class="card-body">
                <h6 style="font-weight: bold;text-align:center;font-size:12px">
             
                '.$row->Firstname.' '.$row->Middlename.' '.$row->Lastname.'
                </h6>
                <hr>
                <span style="font-size: 12px">
               <span style="font-size:11px">Birthdate</span>  : '.date("F j, Y",strtotime($row->Birthdate)).'
                <br>
                <span style="font-size:11px"> Address </span> : '.$row->Address.'

          
                <br>';
                if($row->Honors){
                    ?>
            <span style="font-size:11px"> Honors </span> : 
                <br>
              <textarea 
              readonly
              style="border: none;outline:none;-moz-user-select: none;
              -webkit-user-select: none;
              -ms-user-select: none;
              user-select: none;
              background-color:transparent;resize:none;cursor:default"><?php echo $row->Honors?></textarea>
            </span>
                    <?php
                }
              
             
            echo '
                </div>
               ';

               ?>
         <div class="card-footer">
                    <div class="btn-group" style="position:absolute;bottom:10px;">
         <button class=" btn btn-link btn-sm text-success">
               <i class="fas fa-edit"></i>
                        </button>

<button class=" btn btn-link btn-sm text-danger">
                              <i class="fas fa-trash"></i>
                                       </button>
                    </div>
                  
                </div>
               <?php

             echo '   
            </div>
        </div>
            ';
           }

     
         
        
    }
}
