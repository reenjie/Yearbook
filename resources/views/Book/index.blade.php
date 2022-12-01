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
                swal("Success!", "{{session()->get('alert')}}", "success");

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
                            <div class="  @if(Auth::user()->Role==1) col-md-12 @else  col-md-6 @endif">
                                <select name="" class="form-control" id="filterbatch">
                                    <option value="">Select Batch</option>
                                    @foreach ($batch as $b)
                                    <option value="{{$b->id}}">{{$b->Name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                            @if(Auth::user()->Role==1)
                      <input type="hidden" id="filtersection" value="{{Auth::user()->SectionID}}" >
                            @else
                                <select id="filtersection" name="" class="form-control" id="">
                                    <option value="">Select Section</option>
                                    @foreach ($section as $s)
                                        <option value="{{$s->id}}">{{$s->Name}}</option>
                                    @endforeach
                                </select>

                                @endif
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