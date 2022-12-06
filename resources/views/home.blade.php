@extends('layouts.app', [
    'namePage' => 'Dashboard',
    'class' => 'login-page sidebar-mini ',
    'activePage' => 'home',
    'backgroundImage' => asset('now') . "/img/bg14.jpg",
])

@section('content')
  <div class="panel-header panel-header-sm">
    
  @php
    $client = DB::select('select * from users where  Role = 2 ');
    $instructor = DB::select('select * from users where Role =1 ');
    $student = DB::select('select * from students');
  @endphp
  </div>
  <div class="content">
    <div class="row">
      <div class="col-md-4 d-flex align-stretch-item">
        <div class="card " style="border-left:10px solid #325aa8">
          <div class="card-header">
          <h1 style="float:right"><i class="fas fa-user-circle"></i></h1>
            <h4 class="card-title">Total Number of Clients</h4>
            <h1>{{count($client)}}</h1>
          </div>
         
         
        </div>
      </div>
      <div class="col-md-4  d-flex align-stretch-item">
        <div class="card " style="border-left:10px solid #a83250">
          <div class="card-header">
          <h1 style="float:right"><i class="fas fa-users"></i></h1>
          <h4 class="card-title">Instructors</h4>
          <h1>{{count($instructor)}}</h1>
          </div>
         
        
        </div>
      </div>
      <div class="col-md-4  d-flex align-stretch-item">
        <div class="card " style="border-left:10px solid #a88532">
          <div class="card-header">
            <h1 style="float:right"><i class="fas fa-users"></i></h1>
            <h4 class="card-title">Students</h4>
            <h1>{{count($student)}}</h1>
          </div>
        
       
        </div>
      </div>
    </div>
    <div class="container ">
    <div id="chartContainer" style="height: 300px; width: 100%;"></div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
  </div>
 
  </div> 
  @php
  $downloads = DB::select('SELECT count(userID) as userCount,created_at FROM yearbookprints GROUP BY  DATE_FORMAT(created_at,"%Y-%m-%d") desc;');
  @endphp


  <script>
window.onload = function () {
	
var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	
	title:{
		text:"Total Prints of Yearbook"
	},
	axisX:{
		interval: 1
	},
	axisY2:{
		interlacedColor: "rgba(1,77,101,.2)",
		gridColor: "rgba(1,77,101,.1)",
		title: ""
	},
	data: [{
		type: "bar",
		name: "companies",
		axisYType: "secondary",
		color: "#014D65",
		dataPoints: [
      @foreach($downloads as $row)

        { y: {{$row->userCount}}, label: "{{date('F j,Y',strtotime($row->created_at))}}" },
         
      @endforeach
		
		
		]
	}]
});
chart.render();

}
</script>
</script>
@endsection
