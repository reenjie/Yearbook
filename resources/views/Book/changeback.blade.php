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
    <div class="card" style="background-color: #F9F5E7;">
        <div class="card-body">
            <button onclick="window.location.href='{{route('books')}}' " class="btn btn-link btn-sm text-primary">Back</button>
            @if(session()->has('batchselected'))
          
            <h4>
                Manage Back Covers
            </h4>

            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal">
                Add
            </button>

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add Back Cover</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <form action="{{route('SaveFPage')}}" method="post" enctype="multipart/form-data">
                            @csrf

                            <div class="modal-body">


                                <h6>
                                    Title
                                </h6>
                                <input type="hidden" name="pagetype" value="1">
                                <input type="text" class="form-control mb-2" name="title">
                                <div class="custom-control custom-switch mb-2">
                                    <input type="checkbox" class="custom-control-input" id="customSwitch1">
                                    <label class="custom-control-label" for="customSwitch1">Multiple Image</label>
                                </div>
                                <h6>
                                    Attach Image File
                                </h6>
                                <input type="file" name="attachfile" accept="image/*" class="form-control mb-2" id="imgfile">
                                <input type="hidden" name="addtype" id="addtype" value="single">

                                <span style="font-size:14px">
                                    Other Info :
                                </span>
                                <textarea name="otherinfo" class="form-control" id="" placeholder="Name,Address Etc.." cols="30" rows="10"></textarea>
                                <h6 class="mt-2">
                                    Message
                                </h6>
                                <textarea name="message" class="form-control" id="" cols="30" rows="10"></textarea>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>



            @if(session()->has('success'))
            <div class="alert alert-success text-dark alert-dismissible fade show" role="alert">
                {{session()->get('success')}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif


            @php
            $frontpages = DB::Select('SELECT * FROM `frontpages` where pagetype=1');

            $photos = DB::Select('SELECT * FROM `photos` where frontpageID in (select id from frontpages where pagetype = 1) ');


            @endphp


            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-10">
                    @foreach($frontpages as $row)
                    <div class="card shadow">
                        <div class="card-body">
                            <span class="" style="font-size:11px;color:gray">Back Contents</span>
                            <div class="row">
                                <div class="col-md-4"></div>
                                <div class="col-md-6"></div>
                                <div class="col-md-2">

                                    <button class="btn btn-link text-danger delete" data-id="{{$row->id}}" style="float:right"><i class="fas fa-trash-can"></i></button>
                                    <button class="btn btn-link text-success" style="float:right" data-toggle="modal" data-target="#editmodal{{$row->id}}"><i class="fas fa-edit"></i></button>

                                    <div class="modal fade" id="editmodal{{$row->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Edit Back Cover</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                        
                                                <form action="{{route('SaveEditFPage')}}" method="post" enctype="multipart/form-data">
                                                    @csrf
                        
                                                    <div class="modal-body">
                                                        <input type="hidden" name="id" value="{{$row->id}}">
                        
                                                        <h6>
                                                            Title
                                                        </h6>
                                                        <input type="text" class="form-control mb-2" name="title" value="{{$row->title}}">
                                                        {{-- <div class="custom-control custom-switch mb-2">
                                                            <input type="checkbox" class="custom-control-input" id="customSwitch2">
                                                            <label class="custom-control-label" for="customSwitch2">Multiple Image</label>
                                                        </div> --}}
                                                        <h6>
                                                          Upload to  Update Image File
                                                        </h6>
                                                        <input type="file" name="attachfile" accept="image/*" class="form-control mb-2" id="imgfile2">
                                                        <input type="hidden" name="addtype" id="addtype2" value="single">
                        
                                                        <span style="font-size:14px">
                                                            Other Info :
                                                        </span>
                                                        <textarea name="otherinfo" class="form-control" id="" placeholder="Name,Address Etc.." cols="30" rows="10">{{$row->otherinfo}}</textarea>
                                                        <h6 class="mt-2">
                                                            Message
                                                        </h6>
                                                        <textarea name="message" class="form-control" id="" cols="30" rows="10">{{$row->message}}</textarea>
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
                            </div>

                            <h6>{{$row->title}}</h6>
                            @if($row->file == '0x')

                            <div class="p-3">
                                @foreach($photos as $src)
                                @if($src->backpageID == $row->id)
                                <img src="{{asset('public/photos').'/'.$src->file}}" alt="" style="width:300px;height:300px" />
                                @endif
                                @endforeach

                            </div>


                            @else
                            @isset($row->file) 

                           
                            <div class="p-3" style="text-align:center">
                                <img src="{{asset('public/photos').'/'.$row->file}}" alt="" style="width:300px;height:300px" />
                                <br>
                                <span style="font-weight:bold;">{{$row->otherinfo}}</span>
                            </div>
                            @endisset


                            @endif
                            @if($row->message)
                            <div class="p-5">
                                <textarea name="" id="" cols="30" rows="50" style="width:100%;outline:none;border:none;resize:none;height:auto;max-height: 500px;
  "> {{$row->message}}</textarea>
                            </div>
                            @endif



                        </div>
                    </div>
                    @endforeach

                </div>
                <div class="col-md-1"></div>
            </div>
            @else
            <form action="{{route('setBatch')}}" method="post">
                @csrf
                <h5>Select Batch to Manage | Back Page</h5>
                @php
                $batch = DB::select('select * from batches');
    
              @endphp
                <select required name="Batch" id="" class="form-control">
                  <option value="">Select Batch</option>
                  @foreach($batch as $b)
                <option value="{{$b->id}}">{{$b->Name}}</option>
                  @endforeach
                </select>
    
                <button type="submit" class="btn btn-primary mt-3">Submit</button>
              </form>
            @endif

     
        </div>
    </div>
</div>

<script>
    $('.delete').click(function() {
        var id = $(this).data('id');
        swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    window.location.href = "{{route('deletePages')}}?id=" + id;
                }
            });
    })
    $('#customSwitch1').click(function() {
        if ($(this).prop("checked") == true) {
            $('#imgfile').attr('multiple', true);
            $('#imgfile').attr('name', "attachfile[]");
            $('#addtype').val('multiple');
        } else if ($(this).prop("checked") == false) {
            $('#imgfile').removeAttr('multiple');
            $('#imgfile').attr('name', "attachfile");
            $('#addtype').val('single');
        }
    })

    $('#customSwitch2').click(function() {
        if ($(this).prop("checked") == true) {
            $('#imgfile2').attr('multiple', true);
            $('#imgfile2').attr('name', "attachfile[]");
            $('#addtype2').val('multiple');
        } else if ($(this).prop("checked") == false) {
            $('#imgfile2').removeAttr('multiple');
            $('#imgfile2').attr('name', "attachfile");
            $('#addtype2').val('single');
        }
    })
</script>

@endsection