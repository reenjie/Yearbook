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
    <div class="row">
    
    <div class="card " style="background-color: rgb(255, 215, 163)">
        <div class="card-body" >
          @if(Auth::user()->printcount > 0)
          <button  target="_blank" style="position: fixed;right:10px;top:50px;z-index:9999;background-color:white;border:2px solid orange" class="btn btn-link shadow-lg" style="float: right" id="download">PRINT <i class="fas fa-download"></i></button>
          @endif
          <h5>You have <span id="chances"></span> Downloads Remaining..</h5>
           <br>
      
           <div id="printpage">
           <style>
               * {
    -webkit-print-color-adjust: exact !important;   /* Chrome, Safari 6 – 15.3, Edge */
    color-adjust: exact !important;                 /* Firefox 48 – 96 */
    print-color-adjust: exact !important;           /* Firefox 97+, Safari 15.4+ */
}
          .bgyearbook{
            background-image:url('https://img.freepik.com/free-vector/graduation-greeting-card_53876-89341.jpg?w=740&t=st=1670294908~exp=1670295508~hmac=6c5367105b93ffc370a6892b37d896d56e197c259ca13639505361ca43d33aaa');
            background-repeat:no-repeat;
            background-position:center;
            background-size:cover;
          
          }
       
       </style>
            <div class="card " style="background-color:#e8ebed">
              <div class="card-body p-5" id="title" >
                <h1 style="font-weight: bold">DPLMHS YEARBOOK</h1>
              </div>
            </div>
            
            @foreach ($section as $item)

                 
            <div class="card mb-2  bgyearbook" >
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
                     
                        <div class="card-body" >
                          <h6 style="text-align: center">
                            <img src="{{asset('photos').'/'.$row->photo}}" style="width: 80px;height:80px; border-radius: 360px;" class=" mb-2" alt="">
                          </h6>
                          <h6 style="font-weight: bold;text-align:center;font-size:12px">
                            {{$row->Firstname.' '.$row->Middlename.' '.$row->Lastname}}
                          </h6> 
                          <div style="padding:5px;width:200px;text-align:center">
                        
                        <span style="font-size: 12px;font-weight:Bold ">
                            <span style="font-size:11px">Birthdate</span>  : {{date("F j, Y",strtotime($row->Birthdate))}}
                             <br>
                             <span style="font-size:11px"> Address </span> :{{$row->Address}}
             
                       
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
 
      
      

  @media print{
    .bgyearbook{
    }
  }
  </style>
      
  <script>
    getCount();
    function getCount(){
      
      $.ajax({
  method: "GET",
  url: "{{route('getDownloadChance')}}",
  data: { id:1 }
    })
  .done(function( msg ) {
    if(msg <= 0){
      $('#download').addClass('d-none');
    }
    $('#chances').text(msg);
  });
    }

$('#download').click(function(){

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
  data: { id:1 }
    })
  .done(function( msg ) {
    getCount();
 var restorepage = $('body').html();
var printcontent = $('#printpage').clone();
$('body').empty().html(printcontent);
window.print();
$('body').html(restorepage);
  });

  }
});
   



//-------------------------------------------------------//
//       var myDiv = document.getElementById('printpage');
// var newWindow = window.open('', 'SecondWindow', 'toolbar=0,stat=0');
// var style = newWindow.document.createElement('link');
// style.type = "text/css";
// style.rel = "stylesheet";
// style.href = "{{ asset('assets') }}/css/bootstrap.min.css";
// style.media = "all";
// var newstyle = newWindow.document.createElement('link');
// newstyle.type = "text/css";
// newstyle.rel = "stylesheet";
// newstyle.href = "{{ asset('assets') }}/css/print.css";
// newstyle.media = "all";
// newWindow.document.write("<html><body " +
// "class='' " +
// " onload='window.print()'>" +
// myDiv.innerHTML +
// "</body></html>");
// newWindow.document.getElementsByTagName("head")[0].appendChild(style);
// newWindow.document.close();
    // window.print();
    })
  </script>
 
@endsection