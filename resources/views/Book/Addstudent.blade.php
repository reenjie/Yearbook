@extends('layouts.app', [
    'class' => 'sidebar-mini ',
    'namePage' => 'Book',
    'activePage' => 'books',
    'activeNav' => '',
])

@section('content')
  <div class="panel-header panel-header-sm">
   
  </div>
  <div class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
            
          <div class="card-body">
          <i style="float: right" class="fas fa-book"></i>
        
         
            <button onClick="window.location.href='{{route('books')}}'" class="btn btn-link text-primary btn-sm">Back</button>
            
            <br>
            <form action="{{route('submitstudent')}}" method="post" enctype="multipart/form-data" >
                @csrf
            <div class="container">
              
                <h6>Personal Information</h6>
              
                <div class="row">
                <div class="col-md-6">
                        
                        <span style="font-size:14px">Student ID</span>
                              <input required name='studentid' type="text" value="" class="mb-2 form-control">
                        </div>
                        <div class="col-md-6"></div>
                    <div class="col-md-4">
                        <span style="font-size:14px">First Name</span>
                        <input required name='firstname' type="text" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <span style="font-size:14px">Middle Name</span>
                        <input required name="middlename" type="text" class="form-control">
                    </div>

                    <div class="col-md-4">
                        <span style="font-size:14px">Last Name</span>
                        <input required name="lastname" type="text" class="form-control">
                    </div>

                    <div class="col-md-4">
                        <span style="font-size:14px">Sex</span>
                      <select name="sex" class="form-control mb-2" required id="">
                        <option value="">Select Sex</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                      </select>
                    </div>

                    <div class="col-md-4">
                        <span style="font-size:14px">Birthdate</span>
                 <input type="date" class="form-control" name="birthdate" required>
                    </div>
                    <div class="col-md-4 "></div>
                    
                    <div class="col-md-12">
                        <span class="" style="font-size:14px">Address</span>
               <textarea name="address"  placeholder="Type Address here .." class="form-control mb-2 " id=""  rows="4" required></textarea>
                    </div>


                    <div class="col-md-6">
                      <span style="font-size:14px">Section</span>
                      @if(Auth::user()->Role == 1)
                      @foreach ($section as $s)
                      @if($s->id == Auth::user()->SectionID)
                      <input type="hidden" readonly name="section" value="{{$s->id}}" >
                      <h6>{{$s->Name}}</h6>
                      @endif
                    @endforeach
                      
                      @else 
                    
                      <select name="section" class="form-control mb-2" required id="">
                        <option value="">Select Section</option>
                        @foreach ($section as $s)
                                        <option value="{{$s->id}}">{{$s->Name}}</option>
                                    @endforeach
                     
                      </select>
                      @endif
                     
                    </div>

                    

                    <div class="col-md-6 mb-2">
                        <span style="font-size:14px">Batch</span>
                      <select name="batch" class="form-control mb-2" required id="">
                        <option value="">Select Batch</option>
                        @foreach ($batch as $b)
                                    <option value="{{$b->id}}">{{$b->Name}}</option>
                                    @endforeach
                      </select>
                    </div>

                    <div class="col-md-12">
                        <span class="" style="font-size:14px">Honors</span>
               <textarea name="honors" placeholder="Indicate Honors Here .." class="form-control mb-2 " id=""  rows="4" ></textarea>
                    </div>

                    <div class="col-md-3">
                        <div class="card mt-2 shadow-lg">
                            <div class="card-body">
                                <h6>UPLOAD PHOTO <i class="fas fa-upload"></i></h6>
                                <input accept="image/*" name="photo" type="file" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <button type="submit"  style="float: right;" class="btn btn-primary mt-5">Submit <i class="fas fa-check-circle"></i></button>
                    </div>

                    
                </div>
            </div>
        </form>

            </div>

          </div>
        </div>
      </div>


@endsection