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
        <div class="card" style="background-color: #f5f6f6">
            @if(session()->has('alert'))
            <script>
              
              $(document).ready(function(){
                swal("New Student Added!", "A New Student Added Successfully!", "success");

              });
            
            </script>
            @endif
          <div class="card-body">
          <i style="float: right" class="fas fa-book"></i>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <div class="card shadow border-secondary   border" style="border-radius: 10px">
                        <div class="card-body">
                            <h6>NAVIGATION</h6>
                          <div class="row">
                            <div class="col-md-6">
                                <select name="" class="form-control" id="filterbatch">
                                    <option value="">Select Batch</option>
                                    @foreach ($batch as $b)
                                    <option value="{{$b->id}}">{{$b->Name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <select id="filtersection" name="" class="form-control" id="">
                                    <option value="">Select Section</option>
                                    @foreach ($section as $s)
                                        <option value="{{$s->id}}">{{$s->Name}}</option>
                                    @endforeach
                                </select>
                            </div>
                          </div>
                        </div>
                    </div>

                  
                </div>
            </div>
            <div class="container">
                <button onClick="window.location.href='{{route('addStudent')}}'" class="btn btn-primary">
                  <i class="fas fa-plus-circle"></i>  New Student
                </button>


  


                <input id="searchvalue" style="width:300px;position: fixed;
                bottom:20px;
                right:10px;
                z-index:1;
                background-color:rgb(36, 28, 28);
                color:white;
                padding:10px;
                " type="text" class="form-control" placeholder="Search for ID, Name or Lastname">
                {{-- /style="height: 100vh;overflow-y:scroll" --}}
                <div class="grads" > 
                    <div class="row" id="data">
                        {{-- @foreach ($student as $row)
                        <div class="col-md-3 d-flex align-items-stretch">
                            <div class="card bg-light shadow-lg">
                                <div class="card-header">
                                
                                
                              <img src="{{asset('photos').'/'.$row->photo}}" style="width: 100%;height:200px" alt="">
                                </div>
                                <div class="card-body">
                                <h6 style="font-weight: bold;text-align:center;font-size:12px">
                             
                                {{$row->Firstname.' '.$row->Middlename.' '.$row->Lastname}}
                                </h6>
                                <hr>
                                <span style="font-size: 12px">
                               <span style="font-size:11px">Birthdate</span>  : {{date('F j, Y',strtotime($row->Birthdate))}}
                                <br>
                                <span style="font-size:11px"> Address </span> : {{$row->Address}}
    
                          
                                <br>
                               
                                @if($row->Honors)
                                <span style="font-size:11px"> Honors </span> : 
                                <br>
                              <textarea 
                              readonly
                              style="border: none;outline:none;-moz-user-select: none;
                              -webkit-user-select: none;
                              -ms-user-select: none;
                              user-select: none;
                              background-color:transparent;resize:none;cursor:default">{{$row->Honors}}</textarea>
                            </span>
                                @endif
                             
    
                                </div>
                                <div class="card-footer">
                                    <div class="btn-group">
                         <button class=" btn btn-link btn-sm text-success">
                               <i class="fas fa-edit"></i>
                                        </button>
                                    </div>
                                    <div class="btn-group">
                                        <button class=" btn btn-link btn-sm text-danger">
                                              <i class="fas fa-trash"></i>
                                                       </button>
                                                   </div>
                                </div>
                            </div>
                        </div>
                        @endforeach --}}
                       
                    </div>
                </div>
             
                
            </div>

            </div>

          </div>
        </div>
      </div>


      <script>
      
        $(document).ready(function(){
            $('#filtersection').change(function(){
                var section = $(this).val();
                var batch = $('#filterbatch').val();
                var value = $('#searchvalue').val();
                const search = {
                  value:value,
                  batch:batch,
                  section:section,
                }
                fetchdata(search);
            })

            $('#filterbatch').change(function(){
                var batch = $(this).val();
                var value = $('#searchvalue').val();
                var section = $('#filtersection').val();
               
                const search = {
                  value:value,
                  batch:batch,
                  section:section,
                }
                fetchdata(search);
            })

            $('#searchvalue').keyup(function(){
                var value = $(this).val();
                var batch = $('#filterbatch').val();
                var section = $('#filtersection').val();
                const search = {
                  value:value,
                  batch:batch,
                  section:section,
                }
                fetchdata(search);
            })

            fetchdata('');
        function fetchdata(searchfetch){
            $('#data').html('<div style="position:Relative;top:50%;left:50%;transform:translate(-50%,-50%);" class="d-flex justify-content-center"><div class="spinner-border" role="status"><span class="sr-only"></span> </div></div><br/><br/>');
        

            $.ajax({
              url: "{{route('fetchstudent')}}",
              method: "get",
              data : {user:1,search:searchfetch},
              success : function(data){
                
           $('#data').html(data);
                     
              }
            })
        }
        });
     
      </script>

@endsection