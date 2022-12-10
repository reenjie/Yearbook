@extends('layouts.app', [
    'class' => 'sidebar-mini ',
    'namePage' => 'Clients',
    'activePage' => 'client',
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
                  Batch & Section
                  </th>
                  <th>
                   Registered Date
                   </th>
                  <th class="text-center">
                  Status
                  </th>
                  @if(Auth::user()->Role==1)
                  <th class="text-center">
                    Order
                    </th>
                    <th class="text-center">
                    Action
                 </th>
                 @endif
                </thead>
                <tbody>
                  @foreach ($data as $item)
                  <tr>
                    <td class="text-center" style="font-weight: bold;text-transform:uppercase">
                  {{ $item->Firstname.' '.$item->Middlename.' '.$item->Lastname}}
                  <br>
                  <span style="font-size:11px;font-weight:normal">StudentID : 
                  @foreach($student as $st)
                    @if($st->id == $item->StudentID)
                    {{$st->studentid}}
                    @endif

                  @endforeach
                </span>
                    </td>
                    <td class="text-center">
                   {{$item->Sex}}
                    </td>
                    <td  class="text-center">
                    <span style="font-size:11px">BATCH :
                      <span style="font-size:15px;font-weight:bold">
                      @foreach ($batch as $b)
                            @if($b->id == $item->BatchID)
                        <span style="color:rgb(86, 145, 194)"> {{$b->Name}}</span>
                           @endif
                        @endforeach
                    </span>
                    </span>
                    <br>
                    
                      <span style="font-size:11px">SECTION :
                      <span style="font-size:15px;font-weight:bold">
                      @foreach ($section as $sec)
                            @if($sec->id == $item->SectionID)
                        <span style="color:rgb(86, 145, 194)"> {{$sec->Name}}</span>
                           @endif
                        @endforeach
                    </span>
                    </span>
                    
                  
                    </td>
                    <td class="text-center">
                      {{date('@h:m a Fj,Y',strtotime($item->created_at))}}
                    </td>
                    <td class="text-center">
                    <span class="badge badge-success">VERIFIED</span>
                    </td>
                    @if(Auth::user()->Role==1)
                    <td class="text-center">
                      @if($item->status == 0)
                      None..
                      @elseif($item->status ==1)
                      Yes

                      
                      @elseif($item->status== 3)
                       OK
                        @else 
                      Processing for Delivery...
          
                      @endif
                    </td>
                      <td class="text-center">
                        @if($item->status == 0)
                        Null
                        @elseif($item->status ==1)
                        <button onclick="window.location.href='{{route('confirmOrder',['userid'=>$item->id,'type'=>'confirm'])}}' " class="btn btn-primary btn-sm w-100">Confirm <i class="fas fa-check-circle"></i></button>
                        
                        @elseif($item->status== 3)
                      
                        @else
                        {{-- <button onclick="window.location.href='{{route('confirmOrder',['userid'=>$item->id,'type'=>'cancel'])}}' " class="btn btn-secondary btn-sm w-100">Cancel <i class="fas fa-times-circle"></i></button> --}}
                        @endif
                       
                   </td>
                   @endif
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