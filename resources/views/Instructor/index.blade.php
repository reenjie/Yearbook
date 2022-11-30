@extends('layouts.app', [
    'class' => 'sidebar-mini ',
    'namePage' => 'Instructor',
    'activePage' => 'instructor',
    'activeNav' => '',
])

@section('content')
  <div class="panel-header panel-header-sm">
  
  </div>
  <div class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-plus"></i> Add</button>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="modal-title" id="exampleModalLabel">Add Instructor</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{route('addusers')}}" method="post">
        @csrf
      <div class="modal-body">
        <span>Email <span style="color:red">*</span></span>
        <input required value="{{old('email')}}" type="text" name="email" required class="form-control mb-2" placeholder="Email">
        <span >Firstname <span style="color:red">*</span></span>
        <input required value="{{old('firstname')}}" type="text" name="firstname" required class="form-control mb-2" placeholder="Firstname">
        <span >Middlename <span style="color:red">*</span></span>
        <input required value="{{old('middlename')}}" type="text" name="middlename" required class="form-control mb-2" placeholder="Middlename">
        <span >Lastname <span style="color:red">*</span></span>
        <input id="lastname" value="{{old('lastname')}}" required type="text" name="lastname" required class="form-control mb-2" placeholder="Lastname">

        <span >Sex <span style="color:red">*</span></span>
        <select required name="sex" class=" form-control mb-2" id="">
            <option value="">Select Sex</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
           
        </select>
        <input type="hidden" value="1" name="role">
    

        <div class="row">
            <div  id="section" class="col-md-12 ">
                <span >Section</span>
                <select name="section" class=" form-control mb-2 " id="">
                    <option value="">Select Section</option>
                    @foreach ($section as $item)
                    <option value="{{$item->id}}">{{$item->Name}}</option>
                    @endforeach
                 
                </select>
            </div>
        
        </div>



        <input type="text" id="password" name="password" class="form-control">

        <button id="defaultpassword" type="button" class=" btn btn-info btn-sm">DefaultPassword</button>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
    </form>
    </div>
  </div>
</div>
          </div>
          <div class="card-body">
            @if(session()->has('alert'))
   <div class="alert alert-warning alert-dismissible fade show" role="alert">
   <span style="color:rgb(48, 40, 122);font-weight:bolder"> {{session()->get('alert')}}</span>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
            @endif

            @error('email')
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <span style="color:rgb(241, 212, 212);font-weight:bolder"> {{$message}}</span>
           <button type="button" class="close" data-dismiss="alert" aria-label="Close">
             <span aria-hidden="true">&times;</span>
           </button>
         </div>
                     @enderror
            
            
            <div class="table-responsive">
              <table class="table" style="color:gray">
                <thead class=" text-primary">
                  <th>
                    Name
                  </th>
                  <th>
                   Sex
                  </th>
                  <th>
                  Section
                  </th>
                  <th>
                   Registered Date
                   </th>
                  <th class="text-center">
                  Action
                  </th>
                </thead>
                <tbody>
                  @foreach ($data as $item)
                  <tr>
                    <td class="text-center" style="font-weight: bold;text-transform:uppercase">
                  {{ $item->Firstname.' '.$item->Middlename.' '.$item->Lastname}}
                    </td>
                    <td class="text-center">
                   {{$item->Sex}}
                    </td>
                    <td  class="text-center">
                        @foreach ($section as $sec)
                            @if($sec->id == $item->SectionID)
                        <span style="color:rgb(86, 145, 194)"> {{$sec->Name}}</span>
                           @endif
                        @endforeach
                  
                    </td>
                    <td class="text-center">
                      {{date('@h:m a Fj,Y',strtotime($item->created_at))}}
                    </td>
                    <td class="text-center">
                  <div class="btn-group">
                   @include('Instructor.Editmodal')
                    <button onclick="Delete({{$item->id}})"  class="btn btn-link text-danger btn-sm"><i class="fas fa-trash"></i></button>
                  </div>
                    </td>
                  </tr>
                  @endforeach
               
              
                </tbody>
              </table>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
  <script>
    
    $('#defaultpassword').click(function(){
      var lastname = $('#lastname').val();
      var defaultpassword = 'yearbook_'+lastname;

      $('#password').val(defaultpassword);

    })

    function Delete(id){
      swal({
  title: "Are you sure?",
  text: "Once deleted, you will not be able to recover this ",
  icon: "warning",
  buttons: true,
  dangerMode: true,
})
.then((willDelete) => {
  if (willDelete) {

    window.location.href="{{route('deleteinstructor')}}"+"?id="+id;

  }
});
    }
  </script>
@endsection