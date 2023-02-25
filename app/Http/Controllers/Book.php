<?php

namespace App\Http\Controllers;

use App\Models\Section;
use App\Models\Batch;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Book extends Controller
{
    public function index()
    {
        $batch = Batch::all();
        $section = Section::all();
        $student = Student::all();
        return view('book.index', compact('batch', 'section', 'student'));
    }

    public function StoreStudent()
    {
        $batch = Batch::all();
        $section = Section::all();
        return view('book.Addstudent', compact('batch', 'section'));
    }

    public function store(Request $request)
    {
        $studentid = $request->input('studentid');
        $firstname = $request->input('firstname');
        $middlename = $request->input('middlename');
        $lastname = $request->input('lastname');
        $sex = $request->input('sex');
        $birthdate = $request->input('birthdate');
        $address = $request->input('address');
        $section = $request->input('section');
        $batch = $request->input('batch');
        $honors = $request->input('honors');

        if ($request->file('photo')) {
            $imageName = time() . '.' . $request->file('photo')->getClientOriginalExtension();

            $request->file('photo')->move(public_path('photos'), $imageName);

            Student::create([
                'studentid' => $studentid,
                'Firstname' => $firstname,
                'Middlename' => $middlename,
                'Lastname' => $lastname,
                'Sex' => $sex,
                'Birthdate' => $birthdate,
                'Address' => $address,
                'Honors' => $honors,
                'SectionID' => $section,
                'BatchID' => $batch,
                'photo' => $imageName,
                'download' => 3,
                'diploma' => 0,
            ]);


            $batch = Batch::all();
            $section = Section::all();
            $student = Student::all();

            return redirect()->route('books')->with('alert', 'New Student Added Successfully!');
        }
    }

    public function fetchstudent(Request $request)
    {
        $searchquery = $request->search;

        $section = Section::all();
        $batch = Batch::all();

        if ($searchquery) {

            if (!empty($searchquery['value']) && !empty($searchquery['batch']) && !empty($searchquery['section'])) {

                //search for all



                $data =  DB::select("SELECT * FROM `students` WHERE SectionID  = '" . $searchquery['section'] . "'  and BatchID ='" . $searchquery['batch'] . "' and  Firstname like '%" . $searchquery['value'] . "%' or Middlename like '%" . $searchquery['value'] . "%' or Lastname like '%" . $searchquery['value'] . "%'  ");
            } else 
            if (empty($searchquery['value']) && !empty($searchquery['batch']) && empty($searchquery['section'])) {

                //search for batch
                $data =  DB::select("SELECT * FROM `students` WHERE  BatchID ='" . $searchquery['batch'] . "'  ");
            } else if (empty($searchquery['value']) && empty($searchquery['batch']) && !empty($searchquery['section'])) {
                //search for section



                $data =  DB::select("SELECT * FROM `students` WHERE  SectionID ='" . $searchquery['section'] . "'  ");
            } else if (!empty($searchquery['value']) && empty($searchquery['batch']) && empty($searchquery['section'])) {
                //search for value

                $data =  DB::select("SELECT * FROM `students` WHERE Firstname like '%" . $searchquery['value'] . "%' or Middlename like '%" . $searchquery['value'] . "%' or Lastname like '%" . $searchquery['value'] . "%' ");
            } else if (empty($searchquery['value']) && !empty($searchquery['batch']) && !empty($searchquery['section'])) {
                //search for batch & section 

                $data =  DB::select("SELECT * FROM `students` WHERE  SectionID like '%" . $searchquery['section'] . "%'  and BatchID like '%" . $searchquery['batch'] . "%'  ");
            } else if (!empty($searchquery['value']) && !empty($searchquery['batch']) && empty($searchquery['section'])) {

                //search for value and batch

                if (Auth::user()->Role == 1) {
                    $sectionid = Auth::user()->SectionID;
                    $data =  DB::select("SELECT * FROM `students` WHERE BatchID = '" . $searchquery['batch'] . "' and SectionID = '" . $sectionid . "' and  Firstname like '%" . $searchquery['value'] . "%' or Middlename like '%" . $searchquery['value'] . "%' or Lastname like '%" . $searchquery['value'] . "%'  ");
                } else {
                    $data =  DB::select("SELECT * FROM `students` WHERE BatchID = '" . $searchquery['batch'] . "' and  Firstname like '%" . $searchquery['value'] . "%' or Middlename like '%" . $searchquery['value'] . "%' or Lastname like '%" . $searchquery['value'] . "%'  ");
                }
            } else if (!empty($searchquery['value']) && empty($searchquery['batch']) && !empty($searchquery['section'])) {
                //search for value and section 



                $data =  DB::select("SELECT * FROM `students` WHERE Firstname like '%" . $searchquery['value'] . "%' or Middlename like '%" . $searchquery['value'] . "%' or Lastname like '%" . $searchquery['value'] . "%' and SectionID like '%" . $searchquery['section'] . "%'   ");
            } else {
                $data =  Student::all();
            }
        } else {
            if (Auth::user()->Role == 1) {
                $sectionID = Auth::user()->SectionID;

                $data =  Student::where('SectionID', $sectionID)->get();
            } else {
                $data =  Student::all();
            }
        }



        foreach ($data as $key => $row) {
            echo '
            <div class="col-md-3 d-flex align-items-stretch">
            <div class="card bg-light shadow-lg">
                <div class="card-header">
                
                
              <img src="' . asset("photos") . "/" . $row->photo . '" style="width: 100%;height:200px" alt="">
                </div>
                <div class="card-body">
                <h6 style="font-weight: bold;text-align:center;font-size:12px">
             
                ' . $row->Firstname . ' ' . $row->Middlename . ' ' . $row->Lastname . '
                </h6>
                <hr>
                <span style="font-size: 12px">
               <span style="font-size:11px">Birthdate</span>  : ' . date("F j, Y", strtotime($row->Birthdate)) . '
                <br>
                <span style="font-size:11px"> Address </span> : ' . $row->Address . '

          
                <br>';
            if ($row->Honors) {
?>
                <span style="font-size:11px"> Honors </span> :
                <br>
                <textarea readonly style="border: none;outline:none;-moz-user-select: none;
              -webkit-user-select: none;
              -ms-user-select: none;
              user-select: none;
              background-color:transparent;resize:none;cursor:default"><?php echo $row->Honors ?></textarea>
                </span>
            <?php
            }


            echo '
                </div>
               ';

            ?>
            <div class="card-footer">
                <div class="btn-group " style="position:absolute;bottom:10px;">
                    <button data-toggle="modal" data-target="#exampleModal<?php echo $row->id ?>" data-id="<?php echo $row->id ?>" class="update btn btn-link btn-sm text-success">
                        <i class="fas fa-edit"></i>
                    </button>



                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal<?php echo $row->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content ">
                                <div class="modal-header">
                                    <h6 class="modal-title" id="exampleModalLabel">Edit Student</h6>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="<?php echo route('updatestudent') ?>" method="POST" enctype="multipart/form-data">

                                    <div class="modal-body">

                                        <div class="container">

                                            <input type="hidden" name="_token" value="<?php echo csrf_token() ?>">
                                            <h6>Personal Information</h6>
                                            <input type="hidden" name="id" value="<?php echo $row->id ?>">
                                            <div class="row">

                                                <div class="col-md-6">

                                                    <span style="font-size:14px">Student ID</span>
                                                    <input required name='studentid' type="text" value="<?php echo $row->studentid ?>" class="mb-2 form-control">
                                                </div>
                                                <div class="col-md-6"></div>
                                                <div class="col-md-4">
                                                    <span style="font-size:14px">First Name</span>
                                                    <input required name='firstname' type="text" value="<?php echo $row->Firstname ?>" class="form-control">
                                                </div>
                                                <div class="col-md-4">
                                                    <span style="font-size:14px">Middle Name</span>
                                                    <input required name="middlename" type="text" value="<?php echo $row->Middlename ?>" class="form-control">
                                                </div>

                                                <div class="col-md-4">
                                                    <span style="font-size:14px">Last Name</span>
                                                    <input required name="lastname" type="text" value="<?php echo $row->Lastname ?>" class="form-control">
                                                </div>

                                                <div class="col-md-4">
                                                    <span style="font-size:14px">Sex</span>
                                                    <select name="sex" class="form-control mb-2" required id="">
                                                        <option value="<?php echo $row->Sex ?>"><?php echo $row->Sex ?></option>
                                                        <option value="Male">Male</option>
                                                        <option value="Female">Female</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-4">
                                                    <span style="font-size:14px">Birthdate</span>
                                                    <input type="date" value="<?php echo $row->Birthdate ?>" class="form-control" name="birthdate" required>
                                                </div>
                                                <div class="col-md-4 "></div>

                                                <div class="col-md-12">
                                                    <span class="" style="font-size:14px">Address</span>
                                                    <textarea name="address" placeholder="Type Address here .." class="form-control mb-2 " id="" rows="4" required><?php echo $row->Address ?></textarea>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="card mt-2 mb-2 shadow">
                                                        <div class="card-body">
                                                            <h6>Current Status</h6>
                                                            <div class="row">
                                                                <?php
                                                                if (!Auth::user()->Role == 1) {


                                                                ?>
                                                                    <div class="col-md-6">
                                                                        <span style="font-size:10px">
                                                                            SECTION :

                                                                            <span style="font-size:14px;font-weight:bold">
                                                                                <?php
                                                                                foreach ($section as $s) {
                                                                                    if ($s->id == $row->SectionID) {
                                                                                        echo $s->Name;
                                                                                    }
                                                                                }
                                                                                ?>
                                                                            </span>

                                                                        </span>
                                                                    </div>

                                                                <?php
                                                                }
                                                                ?>

                                                                <div class="col-md-6">
                                                                    <span style="font-size:10px">
                                                                        BATCH :

                                                                        <span style="font-size:14px;font-weight:bold">
                                                                            <?php
                                                                            foreach ($batch as $b) {
                                                                                if ($b->id == $row->BatchID) {
                                                                                    echo $b->Name;
                                                                                }
                                                                            }
                                                                            ?>
                                                                        </span>

                                                                    </span>

                                                                </div>
                                                            </div>




                                                        </div>
                                                    </div>
                                                </div>


                                                <?php
                                                if (!Auth::user()->Role == 1) {
                                                ?>
                                                    <div class="col-md-6">
                                                        <span style="font-size:14px">Section</span>
                                                        <select value="<?php echo $row->SectionID ?>" name="section" class="form-control mb-2" id="">
                                                            <option value="">Select Section</option>

                                                            <?php
                                                            foreach ($section as $s) {
                                                                echo '<option value="' . $s->id . '">' . $s->Name . '</option>';
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                <?php
                                                } else {
                                                ?>
                                                    <input type="hidden" name="section" value="<?php echo Auth::user()->SectionID ?>">
                                                <?php
                                                }
                                                ?>





                                                <div class="col-md-6 mb-2">
                                                    <span style="font-size:14px">Batch</span>
                                                    <select value="<?php echo $row->BatchID ?>" name="batch" class="form-control mb-2" id="">
                                                        <option value="">Select Batch</option>

                                                        <?php
                                                        foreach ($batch as $b) {
                                                            echo '<option value="' . $b->id . '">' . $b->Name . '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>

                                                <div class="col-md-12">
                                                    <span class="" style="font-size:14px">Honors</span>
                                                    <textarea name="honors" value="<?php echo $row->Honors ?>" placeholder="Indicate Honors Here .." class="form-control mb-2 " id="" rows="4"></textarea>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="card mt-2 shadow-lg">
                                                        <div class="card-body">
                                                            <h6>UPLOAD PHOTO <i class="fas fa-upload"></i></h6>
                                                            <input accept="image/*" name="photo" type="file" class="form-control">
                                                            <span class="text-primary" style="font-size:11px">Select File to Update Current Photo</span>
                                                        </div>
                                                    </div>
                                                </div>



                                            </div>
                                        </div>



                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" style="margin-left:5px" class="btn btn-primary">Save changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <button class="delete btn btn-link btn-sm text-danger" data-id="<?php echo $row->id ?>">
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


        ?>
        <script>
            $('.update').click(function() {
                var id = $(this).data('id');


            });

            $('.delete').click(function() {
                var id = $(this).data('id');

                swal({
                        title: "Are you sure?",
                        text: "Once deleted, you will not be able to recover this data ",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {

                            window.location.href = "/deleteStudent" + "?id=" + id;

                        }
                    });
            })
        </script>
<?php

    }

    public function deletestudent(Request $request)
    {
        $id = $request->id;

        Student::findorFail($id)->delete();
        return redirect()->route('books');
    }

    public function updatestudent(Request $request)
    {
        $studentid = $request->input('studentid');
        $firstname = $request->input('firstname');
        $middlename = $request->input('middlename');
        $lastname = $request->input('lastname');
        $sex = $request->input('sex');
        $birthdate = $request->input('birthdate');
        $address = $request->input('address');
        $section = $request->input('section');
        $batch = $request->input('batch');
        $honors = $request->input('honors');
        $id = $request->input('id');






        if ($request->file('photo')) {
            $imageName = time() . '.' . $request->file('photo')->getClientOriginalExtension();
            $request->file('photo')->move(public_path('photos'), $imageName);

            /*     Student::findorFail($id)->update([
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
        ]); */

            if ($section == '' && $batch == '') {
                //update file only

                Student::findorFail($id)->update([
                    'studentid' => $studentid,
                    'Firstname' => $firstname,
                    'Middlename' => $middlename,
                    'Lastname' => $lastname,
                    'Sex' => $sex,
                    'Birthdate' => $birthdate,
                    'Address' => $address,
                    'Honors' => $honors,
                    'photo' => $imageName,

                ]);
            } else if ($section != '' && $batch == '') {
                //echo 'ypdate section w/file only';
                Student::findorFail($id)->update([
                    'studentid' => $studentid,
                    'Firstname' => $firstname,
                    'Middlename' => $middlename,
                    'Lastname' => $lastname,
                    'Sex' => $sex,
                    'Birthdate' => $birthdate,
                    'Address' => $address,
                    'Honors' => $honors,
                    'SectionID' => $section,
                    'photo' => $imageName,

                ]);
            } else if ($section == '' && $batch != '') {
                // echo 'update batch w/file only';
                Student::findorFail($id)->update([
                    'studentid' => $studentid,
                    'Firstname' => $firstname,
                    'Middlename' => $middlename,
                    'Lastname' => $lastname,
                    'Sex' => $sex,
                    'Birthdate' => $birthdate,
                    'Address' => $address,
                    'Honors' => $honors,
                    'BatchID' => $batch,
                    'photo' => $imageName,
                ]);
            } else if ($section != '' && $batch != '') {
                // echo 'update all including file';
                Student::findorFail($id)->update([
                    'studentid' => $studentid,
                    'Firstname' => $firstname,
                    'Middlename' => $middlename,
                    'Lastname' => $lastname,
                    'Sex' => $sex,
                    'Birthdate' => $birthdate,
                    'Address' => $address,
                    'Honors' => $honors,
                    'SectionID' => $section,
                    'BatchID' => $batch,
                    'photo' => $imageName,
                ]);
            }
        } else {

            /* 
         Student::findorFail($id)->update([
            'Firstname'=>$firstname,
            'Middlename'=>$middlename,
            'Lastname'=>$lastname,
            'Sex'=>$sex,
            'Birthdate'=>$birthdate,
            'Address'=>$address,
            'Honors'=>$honors,
            'SectionID'=>$section,
            'BatchID'=>$batch,  
        ]);
        */
            if ($section == '' && $batch == '') {

                // echo 'update some data w no file';
                Student::findorFail($id)->update([
                    'studentid' => $studentid,
                    'Firstname' => $firstname,
                    'Middlename' => $middlename,
                    'Lastname' => $lastname,
                    'Sex' => $sex,
                    'Birthdate' => $birthdate,
                    'Address' => $address,
                    'Honors' => $honors,
                ]);
            } else if ($section != '' && $batch == '') {
                //echo 'ypdate section only';
                Student::findorFail($id)->update([
                    'studentid' => $studentid,
                    'Firstname' => $firstname,
                    'Middlename' => $middlename,
                    'Lastname' => $lastname,
                    'Sex' => $sex,
                    'Birthdate' => $birthdate,
                    'Address' => $address,
                    'Honors' => $honors,
                    'SectionID' => $section,
                ]);
            } else if ($section == '' && $batch != '') {
                // echo 'update batch  only';

                Student::findorFail($id)->update([
                    'studentid' => $studentid,
                    'Firstname' => $firstname,
                    'Middlename' => $middlename,
                    'Lastname' => $lastname,
                    'Sex' => $sex,
                    'Birthdate' => $birthdate,
                    'Address' => $address,
                    'Honors' => $honors,
                    'BatchID' => $batch,
                ]);
            } else if ($section != '' && $batch != '') {
                //  echo 'update all excluding file';

                Student::findorFail($id)->update([
                    'studentid' => $studentid,
                    'Firstname' => $firstname,
                    'Middlename' => $middlename,
                    'Lastname' => $lastname,
                    'Sex' => $sex,
                    'Birthdate' => $birthdate,
                    'Address' => $address,
                    'Honors' => $honors,
                    'SectionID' => $section,
                    'BatchID' => $batch,
                ]);
            }
        }

        return redirect()->route('books')->with('alert', 'Data of Student Updated Successfully!');
    }

    public function changebg()
    {
        $batch = Batch::all();
        return view('Book.bg', compact('batch'));
    }

    public function savebookbg(Request $request)
    {
        $id = $request->batchid;
        $file = $request->file('bgimage');

        $image = time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('photos'), $image);

        Batch::where('id', $id)->update([
            'bg' => $image,
        ]);

        return redirect()->back();
    }

    public function changefront()
    {
        return view('Book.changefront');
    }

    public function changeback()
    {
        return view('Book.changeback');
    }
}
