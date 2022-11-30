@extends('layouts.app', [
    'class' => 'sidebar-mini ',
    'namePage' => 'section',
    'activePage' => 'section',
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
        <h6 class="modal-title" id="exampleModalLabel">Add Section</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{route('addsection')}}" method="post">
        @csrf
      <div class="modal-body">
        <input type="text" name="name" required class="form-control mb-2" placeholder="Section">

        <textarea name="description" placeholder="Description .." class="form-control"  id=""  rows="3"></textarea>
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
                   Created Date
                  </th>
                  <th>
                    Modified Date
                   </th>
                  <th class="text-center">
                  Action
                  </th>
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
                    <td  class="text-center">
                    {{date('@h:m a Fj,Y',strtotime($item->created_at))}}
                    </td>
                    <td class="text-center">
                      {{date('@h:m a Fj,Y',strtotime($item->updated_at))}}
                    </td>
                    <td class="text-center">
                  <div class="btn-group">
                   @include('Section.Editmodal')
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

    window.location.href="{{route('deletesection')}}"+"?id="+id;

  }
});
    }
  </script>
@endsection