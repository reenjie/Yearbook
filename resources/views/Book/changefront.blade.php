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
            <h4>
                Manage Front Covers
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
                            <h5 class="modal-title" id="exampleModalLabel">Add Front Cover</h5>
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
            $frontpages = DB::Select('SELECT * FROM `frontpages` where pagetype=0');

            $photos = DB::Select('SELECT * FROM `photos` where frontpageID in (select id from frontpages where pagetype = 0) ');


            @endphp


            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-10">
                    @foreach($frontpages as $row)
                    <div class="card shadow">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4"></div>
                                <div class="col-md-6"></div>
                                <div class="col-md-2">

                                    <button class="btn btn-link text-danger delete" data-id="{{$row->id}}" style="float:right"><i class="fas fa-trash-can"></i></button>
                                    <button class="btn btn-link text-success" style="float:right"><i class="fas fa-edit"></i></button>
                                </div>
                            </div>

                            <h6>{{$row->title}}</h6>
                            @if($row->file == '0x')

                            <div class="p-3">
                                @foreach($photos as $src)
                                @if($src->frontpageID == $row->id)
                                <img src="{{asset('photos').'/'.$src->file}}" alt="" style="width:300px;height:300px" />
                                @endif
                                @endforeach

                            </div>


                            @else
                            <div class="p-3" style="text-align:center">
                                <img src="{{asset('photos').'/'.$row->file}}" alt="" style="width:300px;height:300px" />
                                <br>
                                <span style="font-weight:bold;">{{$row->otherinfo}}</span>
                            </div>


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
</script>

@endsection