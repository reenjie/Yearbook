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
          $(document).ready(function() {
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

                  @if(Auth::user()->Role==1)

                  @else


                  <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#FileUpload"><i class="fas fa-upload"></i> Upload Yearbook ( <span style="font-size: 10px;">PDF File</span>)</button>

                  <button class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#ExcelFiles"><i class="fas fa-list"></i> YearBooks ( <span style="font-size: 10px;">PDF File</span>)</button>

                  @endif

                  @php
                  $excel = DB::select("SELECT * FROM `excels` where typeof ='yearbookfile' ");

                  $batches = DB::select("SELECT * FROM `batches`");

                  $batcheswexcel = DB::select("SELECT * FROM `batches` where id in (select batch from excels where typeof ='yearbookfile')");
                  @endphp

                  <div class="modal fade" id="ExcelFiles" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h6 class="modal-title" id="exampleModalLabel">Yearbook  ( <span style="font-size: 10px;">PDF FILE</span>)</h6>
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
                          <h6 class="modal-title" id="exampleModalLabel">Upload Yearbook ( <span style="font-size: 10px;">PDF File</span>)</h6>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <form action="{{route('addexcelfile')}}" method="post" enctype="multipart/form-data">
                          @csrf
                          <div class="modal-body">
                            <h6 class="mt-2 mb-2">Select  File</h6>
                            <input type="file" name="excellfile" required accept="application/pdf" class="form-control" />

                            <h6 class="mt-2">Select Batch</h6>
                            <select name="batch" required class="form-control mb-2" id="">
                              @foreach($batches as $row)
                              <option value="{{$row->id}}">{{$row->Year}}</option>
                              @endforeach
                            </select>

                            <input type="hidden" name="typeof" value="yearbookfile">

                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>


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
                      <input type="hidden" id="filtersection" value="{{Auth::user()->SectionID}}">
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
                @if(Auth::user()->Role==0)
                <div class="col-md-12">

                  <button onclick="window.location.href='{{route('changefront')}}' " class="btn btn-dark w-100 btn-sm">Manage Front Covers,Introductions etc <i class="fas fa-cogs"></i></button>
                  <button onclick="window.location.href='{{route('changeback')}}' " class="btn btn-dark w-100 btn-sm">Manage Back Covers,Ending Messages etc <i class="fas fa-cogs"></i></button>
                  <button onclick="window.location.href='{{route('changebg')}}' " class="btn btn-dark w-100 btn-sm">Manage Book Background <i class="fas fa-image"></i></button>
                </div>
                @endif
              </div>



            </div>


          </div>
          <div class="container">
            <button onClick="window.location.href='{{route('addStudent')}}'" class="btn btn-primary">
              <i class="fas fa-plus-circle"></i> New Student
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
            <div class="grads">
              <div class="row" id="data">
              </div>
            </div>


          </div>

        </div>

      </div>
    </div>
  </div>


  <script>
    $(document).ready(function() {

      $('.download').click(function() {
        var file = $(this).data('file');
        window.location.href = '{{asset("excel")}}/' + file;
      })
      $('#filtersection').change(function() {
        var section = $(this).val();
        var batch = $('#filterbatch').val();
        var value = $('#searchvalue').val();
        const search = {
          value: value,
          batch: batch,
          section: section,
        }
        fetchdata(search);
      })

      $('#filterbatch').change(function() {
        var batch = $(this).val();
        var value = $('#searchvalue').val();
        var section = $('#filtersection').val();

        const search = {
          value: value,
          batch: batch,
          section: section,
        }
        fetchdata(search);


      })

      $('#searchvalue').keyup(function() {
        var value = $(this).val();
        var batch = $('#filterbatch').val();
        var section = $('#filtersection').val();
        const search = {
          value: value,
          batch: batch,
          section: section,
        }
        fetchdata(search);

      })

      fetchdata('');

      function fetchdata(searchfetch) {
        $('#data').html('<div style="position:Relative;top:50%;left:50%;transform:translate(-50%,-50%);" class="d-flex justify-content-center"><div class="spinner-border" role="status"><span class="sr-only"></span> </div></div><br/><br/>');


        $.ajax({
          url: "{{route('fetchstudent')}}",
          method: "get",
          data: {
            user: 1,
            search: searchfetch
          },
          success: function(data) {

            $('#data').html(data);

          }
        })
      }
    });
  </script>

  @endsection