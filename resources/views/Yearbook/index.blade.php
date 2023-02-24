@extends('layouts.app', [
'class' => 'sidebar-mini ',
'namePage' => 'My Year-Book',
'activePage' => 'yearbook',
'activeNav' => '',
])

@section('content')
<div class="panel-header panel-header-sm">

</div>
<div class="content">
  @if(Auth::user()->status == 3)
  @isset($otherbatch)
  <div class="row">
    <div class="col-md-6">
      <div class="card bg-light p-3 shadow-lg">
        <div class="card-body">
          <h6>View</h6>
          <select class="form-control" name="" id="selectbatch">
            @foreach ($otherbatch as $bs)
            <option value="">Select Batch</option>
            <option value="{{$bs->id}}">{{$bs->Name}}</option>
            @endforeach
          </select>
        </div>
      </div>
    </div>
  </div>
  @else
  <div class="card">
    <div class="card-body">
      <button class="btn btn-link text-primary" onclick="window.location.href='{{route('yearbook')}}' ">Back</button>
    </div>
  </div>
  @endisset

  @endif
  <div class="row">
    @if(Auth::user()->status == 2)
    <div class="card bg-light shadow-lg p-3">
      <div class="card-body">

        <!-- <button class="btn btn-dark text-light btn-sm" data-toggle="modal" data-target="#exampleModal">Delivery Information <i class="fas fa-info-circle"></i></button>

   -->
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">

              <div class="modal-body">

                <span style="font-size:11px">{{date('Y-m-d')}}</span>
                <h6 style="font-size:12px;font-weight:normal">
                  School is preparing your order.

                </h6>
                <hr>
                <span style="font-size:11px">{{date('Y-m-d')}}</span>
                <h6 style="font-size:12px;font-weight:normal">
                  Courier has taken the Parcel.

                </h6>
                <hr>

                <span style="font-size:11px">{{date('Y-m-d')}}</span>
                <h6 style="font-size:12px;font-weight:normal">
                  Parcel has been shipped. { To your destination }

                </h6>
                <hr>

                <span style="font-size:11px">{{date('Y-m-d')}}</span>
                <h6 style="font-size:12px;font-weight:normal">
                  Parcel has Arrived at the sorting station.

                </h6>
                <hr>

                <span style="font-size:11px">{{date('Y-m-d')}}</span>
                <h6 style="font-size:12px;font-weight:normal">
                  Parcel is out for delivery..

                </h6>
                <hr>




                <br>
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>

              </div>

            </div>
          </div>
        </div>

        <h6>The DPLMHS. has been confirmed and processing your order for delivery.</h6>
        <span style="font-size:14px">For Delivery Concern. Please contact (062) 955 0121 for more info.</span>
        <br>

        <!-- Please <button id="confirmyorder" class="btn btn-primary btn-sm">CONFIRM</button> if you have already received your Order. -->
      </div>
    </div>
    @endif




    <div class="card " style="background-color: rgb(255, 215, 163)">
      <div class="card-body">
        @if(Auth::user()->printcount > 0)

        @isset($otherbatch)

        <button target="_blank" style="position: fixed;right:10px;top:50px;z-index:9999;background-color:white;border:2px solid orange" class="btn btn-link shadow-lg" style="float: right" id="download" data-status="{{Auth::user()->status}}">PRINT <i class="fas fa-download"></i></button>
        @endisset
        @endif
        <h5>You have <span id="chances"></span> Downloads Remaining..</h5>
        <br>

        <div id="printpage">
          <style>
            * {
              -webkit-print-color-adjust: exact !important;
              /* Chrome, Safari 6 – 15.3, Edge */
              color-adjust: exact !important;
              /* Firefox 48 – 96 */
              print-color-adjust: exact !important;
              /* Firefox 97+, Safari 15.4+ */
            }

            .bgyearbook {
              background-image:url('{{$batchbg}}');
              background-repeat: no-repeat;
              background-position: center;
              background-size: cover;

            }
          </style>

          <div class="card " style="background-color:#e8ebed">
            <div class="card-body p-5" id="title">
              <h1 style="font-weight: bold">DPLMHS YEARBOOK</h1>
              @foreach ($batches as $bb)
              <h6>{{$bb->Name}} | {{$bb->Year.'-'.$bb->Year+1}}</h6>
              @endforeach
            </div>
          </div>

          @foreach ($section as $item)


          <div class="card mb-2  bgyearbook">
            <div class="card-body p-5">
              <h5 style="font-weight: bold;text-transform:uppercase"> {{$item->Name}}</h5>
              <h6 style="font-size: 11px;font-weight:normal">Instructor</h6>
              <h6 style="font-weight: bold;font-size:14px"><span style="font-weight:normal">Mr/Mrs</span>
                @foreach ($user as $ins)
                @if($ins->SectionID == $item->id)
                {{$ins->Firstname.' '.$ins->Lastname}}
                @endif
                @endforeach
              </h6>

              <div class="row">
                @foreach ($student as $row)
                @if($item->id == $row->SectionID)
                <div class="d-flex align-items-stretch">
                  <div class=" mb-2 ml-2" style="border-radius:350px;background-color:rgba(244, 248, 255, 0.527)">

                    <div class="card-body">
                      <h6 style="text-align: center">
                        <img src="{{asset('photos').'/'.$row->photo}}" style="width: 80px;height:80px; border-radius: 360px;" class=" mb-2" alt="">
                      </h6>
                      <h6 style="font-weight: bold;text-align:center;font-size:12px">
                        {{$row->Firstname.' '.$row->Middlename.' '.$row->Lastname}}
                      </h6>
                      <div style="padding:5px;width:200px;text-align:center">

                        <span style="font-size: 12px;font-weight:Bold ">
                          <span style="font-size:11px">Birthdate</span> : {{date("F j, Y",strtotime($row->Birthdate))}}
                          <br>
                          <span style="font-size:11px"> Address </span> :{{$row->Address}}


                          <br>
                          @if($row->Honors)
                          <span style="font-size:11px"> Honors </span> :
                          <br>
                          <textarea readonly style="border: none;outline:none;-moz-user-select: none;
                           -webkit-user-select: none;
                           -ms-user-select: none;
                           user-select: none;
                           background-color:transparent;resize:none;cursor:default">{{$row->Honors}}</textarea>
                          @endif
                        </span>


                      </div>


                    </div>

                  </div>


                </div>
                @endif
                @endforeach



              </div>



            </div>
          </div>

          @endforeach

        </div>



      </div>
    </div>
  </div>
</div>
<style>
  @media print {
    .bgyearbook {}
  }
</style>

<script>
  getCount();

  function getCount() {

    $.ajax({
        method: "GET",
        url: "{{route('getDownloadChance')}}",
        data: {
          id: 1
        }
      })
      .done(function(msg) {
        if (msg <= 0) {
          $('#download').addClass('d-none');
        }
        $('#chances').text(msg);
      });
  }

  $('#selectbatch').change(function() {
    var batch = $(this).val();
    window.location.href = '{{route("changebatch")}}?id=' + batch;
  })

  $('#confirmyorder').click(function() {
    swal({
        title: "Order Received?",
        text: "Please make sure you have received the Order.",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          $.ajax({
              method: "GET",
              url: "{{route('printyearbook')}}",
              data: {
                data: 'confirmor'
              }
            })
            .done(function(msg) {
              swal("Thank You!", "Thank you for your purchase and Thank you for being part with us, and Hope to see you soon Grow and Successful.", "success").then(() => {
                window.location.reload();
              });

            });

        }
      });
  })

  $('#download').click(function() {
    var status = $(this).data('status');

    if (status == 0) {
      //Order

      swal({
          title: "Order Your Yearbook now?",
          text: "Order first to get your soft copy yearbook.",
          icon: "warning",
          buttons: true,
          dangerMode: false,
        })
        .then((willDelete) => {
          if (willDelete) {
            $.ajax({
                method: "GET",
                url: "{{route('printyearbook')}}",
                data: {
                  data: 'order'
                }
              })
              .done(function(msg) {
                swal({
                  title: "Order Set!",
                  text: "Your Order Request was send successfully!",
                  icon: "success",
                }).then(() => {
                  window.location.reload();
                });
              });

          }
        });

    } else if (status == 1) {
      //Waiting for confirmation
      swal("Order in Process", "Your order is currently on process. please wait while the Organization process your Order!", "info");
    } else {
      //Download
      swal({
          title: "Are you sure?",
          text: "Once clicked, Please Save it into PDF. Cause it will decrease your chances of Downloading or Saving the yearbook..",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            $.ajax({
                method: "GET",
                url: "{{route('printyearbook')}}",
                data: {
                  data: 'print'
                }
              })
              .done(function(msg) {
                getCount();
                var restorepage = $('body').html();
                var printcontent = $('#printpage').clone();
                $('body').empty().html(printcontent);
                window.print();
                $('body').html(restorepage);
              });

          }
        });
    }






  })
</script>

@endsection