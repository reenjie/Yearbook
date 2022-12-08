@extends('layouts.app', [
    'class' => 'sidebar-mini ',
    'namePage' => 'batch',
    'activePage' => 'batch',
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
            @if(Auth::user()->Role==1)

            @else 
            <button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-plus"></i> Add</button>

            @endif
           

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="modal-title" id="exampleModalLabel">Add Batch</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{route('addbatch')}}" method="post">
        @csrf
      <div class="modal-body">
        <input type="text" name="name" required class="form-control mb-2" placeholder="Batch Name">

        <textarea name="description" placeholder="Description .." class="form-control mb-2"  id=""  rows="3"></textarea>

       <select name="year" required class="form-control mb-2" id="">
        <option value="">Select Year</option>
        @for ($i = date('Y'); $i >= 2020; $i--)
        <option value="{{$i}}">{{$i}}</option>   
        @endfor
       </select>
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

            <div class="table-responsive">
              <table class="table" style="color:gray">
                <thead class=" text-primary">
                  <th>
                    Name
                  </th>
                  <th>
                    Description
                  </th>
                  <th>
                   Year
                  </th>
                  <th>
                   Created Date
                  </th>
                  @if(Auth::user()->Role==1)
                  @else
                  <th class="text-center">
                  Action
                  </th>
                  @endif
                </thead>
                <tbody>
                  @foreach ($data as $item)
                  <tr>
                    <td class="text-center" style="font-weight: bold">
                  {{ $item->Name}}
                    </td>
                    <td class="text-center">
                   {{$item->Description}}
                    </td>
                    <td class="text-center">
                        {{$item->Year.' - '.$item->Year+1}}
                         </td>
                    <td  class="text-center">
                    {{date('@h:m a Fj,Y',strtotime($item->created_at))}}
                    </td>

                    @if(Auth::user()->Role==1)
                    @else
                    <td class="text-center">
                  <div class="btn-group">
                   @include('Batch.Editmodal')
                    <button onclick="Delete({{$item->id}})"  class="btn btn-link text-danger btn-sm"><i class="fas fa-trash"></i></button>
                  </div>
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
    

    function Delete(id){
      swal({
  title: "Are you sure?",
  text: "All Connected Data will be deleted as well and Once deleted, you will not be able to recover this ",
  icon: "warning",
  buttons: true,
  dangerMode: true,
})
.then((willDelete) => {
  if (willDelete) {

    window.location.href="{{route('deletebatch')}}"+"?id="+id;

  }
});
    }
  </script>
@endsection