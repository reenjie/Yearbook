<button class="btn btn-link text-success btn-sm" data-toggle="modal" data-target="#modal{{$item->id}}"><i class="fas fa-edit"></i></button>

<div class="modal fade" id="modal{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h6 class="modal-title" id="exampleModalLabel">Edit Users</h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{route('edituser')}}" method="post">
          @csrf
        <div class="modal-body" style="text-align: left">
            {{-- <span>Email <span style="color:red">*</span></span>
            <input required value="{{$item->email}}" type="text" name="email" required class="form-control mb-2" placeholder="Email"> --}}
            <span >Firstname <span style="color:red">*</span></span>
            <input required value="{{$item->Firstname}}" type="text" name="firstname" required class="form-control mb-2" placeholder="Firstname">
            <span >Middlename <span style="color:red">*</span></span>
            <input required value="{{$item->Middlename}}" type="text" name="middlename" required class="form-control mb-2" placeholder="Middlename">
            <span >Lastname <span style="color:red">*</span></span>
            <input id="lastname" value="{{$item->Lastname}}" required type="text" name="lastname" required class="form-control mb-2" placeholder="Lastname">
    
            <span >Sex <span style="color:red">*</span></span>
            <select required name="sex" class=" form-control mb-2" id="">
                <option value="{{$item->Sex}}">{{$item->Sex}}</option>

                <option value="Male">Male</option>
                <option value="Female">Female</option>
               
            </select>
    
    
            <div class="row">
                <div  id="section" class="col-md-6 d-none">
                    <span >Section</span>
                    <select name="section" class=" form-control mb-2 " id="">
                        <option value="">Select Section</option>
                        @foreach ($section as $sec)
                        <option value="{{$sec->id}}">{{$sec->Name}}</option>
                        @endforeach
                     
                    </select>
                </div>
                <div id="batch" class="col-md-6 d-none">
                    <span >Batch</span>
                    <select name="batch"  class="batch form-control mb-2 " id="">
                        <option value="">Select Batch</option>
                        <option value="0">Admin</option>
                        <option value="1">Instructor</option>
                        <option value="2">Client</option>
                    </select>
                </div>
            </div>
    
          
            <input type="hidden" name="id" value="{{$item->id}}">
          
          
            <select name="student" id="student" class="d-none form-control mb-2" id="">
                <option value="">Select Student</option>
                <option value="0">Admin</option>
                <option value="1">Instructor</option>
                <option value="2">Client</option>
            </select>
    
    


        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button style="margin-left:5px" type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
      </div>
    </div>
  </div>