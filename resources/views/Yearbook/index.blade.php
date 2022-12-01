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
          <button style="position: fixed;right:10px;top:50px;z-index:9999;background-color:white" class="btn btn-link text-success shadow-lg" style="float: right" id="download">DOWNLOAD <i class="fas fa-download"></i></button>
           <h5>You have 3 Downloads Remaining..</h5>
           <br>
           <style>
            @media print{
              .card {
                background-color: yellow
              }
            }
           </style>
           <div id="printpage">
            <div class="card ">
              <div class="card-body p-5" id="title" >
                <h1 style="font-weight: bold">DPLMHS YEARBOOK</h1>
              </div>
            </div>
            @foreach ($section as $item)

                 
            <div class="card mb-2 bg-light">
              <div class="card-body p-5">
               <h5 style="font-weight: bold;"> {{$item->Name}}</h5>
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
                      <div class="" style="border-radius:350px">
                     
                        <div class="card-body" >
                          <h6 style="text-align: center">
                            <img src="{{asset('photos').'/'.$row->photo}}" style="width: 80px;height:80px; border-radius: 360px;" class=" mb-2" alt="">
                          </h6>
                          <h6 style="font-weight: bold;text-align:center;font-size:12px">
                            {{$row->Firstname.' '.$row->Middlename.' '.$row->Lastname}}
                          </h6>
                        
                          <span style="font-size: 12px;">
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

  <script>
    $('#download').click(function(){
      var myDiv = document.getElementById('printpage');
var newWindow = window.open('', 'SecondWindow', 'toolbar=0,stat=0');
var style = newWindow.document.createElement('link');
style.type = "text/css";
style.rel = "stylesheet";
style.href = "{{ asset('assets') }}/css/bootstrap.min.css";
style.media = "all";
newWindow.document.write("<html><body " +
"class='responsive light2012-home-switcher home switcher' " +
" onload='window.print()'>" +
myDiv.innerHTML +
"</body></html>");
newWindow.document.getElementsByTagName("head")[0].appendChild(style);
newWindow.document.close();
     
    })
  </script>
 
@endsection