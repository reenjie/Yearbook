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

          <button class="btn btn-info" data-toggle="modal" data-target="#FileUpload"><i class="fas fa-upload"></i> Upload List ( <span style="font-size: 10px;">CSV File</span>)</button>

          <button class="btn btn-secondary" data-toggle="modal" data-target="#ExcelFiles"><i class="fas fa-list"></i> List ( <span style="font-size: 10px;">CSV File</span>)</button>


          <button class="btn btn-primary" onclick="window.location.href='{{asset('excel').'/template/csvtemplate_yearbook.csv'}}' " ><i class="fas fa-download"></i> Download CSV Template ( <span style="font-size: 10px;">CSV File</span>)</button>
          @endif

          @php
          $excel = DB::select("SELECT * FROM `excels` where typeof ='listfile'");

          $batches = DB::select("SELECT * FROM `batches`");

          $batcheswexcel = DB::select("SELECT * FROM `batches` where id in (select batch from excels where typeof='listfile')");
          @endphp

          <div class="modal fade" id="ExcelFiles" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h6 class="modal-title" id="exampleModalLabel">LIST OF STUDENTS ( <span style="font-size: 10px;">CSV File</span>)</h6>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>

                <div class="modal-body">

                  <table class="table">
                    <thead>
                      <tr>

                        <th scope="col">File</th>
                        <th scope="col">Action</th>

                      </tr>
                    </thead>
                    <tbody>
                      @foreach($batcheswexcel as $row)
                      <tr class="table-danger">
                        <th colspan="3" style="text-align:center">Batch {{$row->Year}} - {{$row->Year + 1}}</th>
                      </tr>
                    
                        @foreach($excel as $ex)
                        <tr>
                        @if($ex->batch == $row->id)
                        <td class="text-primary">
                          {{$ex->file}}
                        </td>
                        <td>
                          <button class="btn btn-sm btn-primary download" data-file="{{$ex->file}}"><i class="fas fa-download"></i></button>

                          <button class="btn btn-sm btn-danger" onclick="DeleteFile({{$ex->id}})"><i class="fas fa-trash"></i></button>
                        </td>
                        @endif
                      </tr>
                        @endforeach

                    




                      @endforeach
                    </tbody>
                  </table>


                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                </div>

              </div>
            </div>
          </div>


          <div class="modal fade" id="FileUpload" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h6 class="modal-title" id="exampleModalLabel">Upload list ( <span style="font-size: 10px;">CSV File</span>)</h6>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <form action="{{route('addexcelfile')}}" method="post" enctype="multipart/form-data">
                  @csrf
                  <div class="modal-body">
                    <span style="font-size:11px;color:red">Please ensure that you have utilized the CSV template, otherwise,import will be a failure.</span>
                    <h6 class="mt-2 mb-2">Select CSV File</h6>
                    <input type="file" name="excellfile" required accept="text/csv" class="form-control" />

                    <h6 class="mt-2">Select Batch</h6>
                    <select name="batch" required class="form-control mb-2" id="">
                      @foreach($batches as $row)
                      <option value="{{$row->id}}">{{$row->Year}}</option>
                      @endforeach
                    </select>

                    <input type="hidden" name="typeof" value="listfile">

                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                  </div>
                </form>
              </div>
            </div>
          </div>


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

                    <textarea name="description" placeholder="Description .." class="form-control mb-2" id="" rows="3"></textarea>

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
                  <td class="text-center">
                    {{date('@h:m a Fj,Y',strtotime($item->created_at))}}
                  </td>

                  @if(Auth::user()->Role==1)
                  @else
                  <td class="text-center">
                    <div class="btn-group">
                      @include('Batch.Editmodal')
                      <button onclick="Delete({{$item->id}})" class="btn btn-link text-danger btn-sm"><i class="fas fa-trash"></i></button>
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
  $('.download').click(function() {
    var file = $(this).data('file');
    window.location.href = '{{asset("excel")}}/' + file;
  })

  function DeleteFile(id) {
    swal({
        title: "Are you sure?",
        text: "Once Deleted you will not be able to recover it. ",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {

          window.location.href = "{{route('deletefile')}}" + "?id=" + id;

        }
      });
  }

  function Delete(id) {
    swal({
        title: "Are you sure?",
        text: "All Connected Data will be deleted as well and Once deleted, you will not be able to recover this ",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {

          window.location.href = "{{route('deletebatch')}}" + "?id=" + id;

        }
      });
  }
</script>
@endsection