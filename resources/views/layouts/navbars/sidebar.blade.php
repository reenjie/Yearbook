<div class="sidebar" data-color="orange">
  <!--
    Tip 1: You can change the color of the sidebar using: data-color="blue | green | orange | red | yellow"
-->
  <div class="logo">
    <p style="font-weight: bold;display:flex;font-size:12px" >DPLMHS  <h5 style="color:white">Year-Book</h5></p>
   
   
  </div>

  <div class="sidebar-wrapper" id="sidebar-wrapper">
    <ul class="nav">
    <li class="@if ($activePage == 'home') active @endif">
        <a href="{{ route('home') }}">
          <i class="now-ui-icons design_app"></i>
          <p>{{ __('Dashboard') }}</p>
        </a>
      </li>

      @if(Auth::user()->Role == 1)
  <li class="@if ($activePage == 'books') active @endif">
          <a href="{{ route('books') }}">
            <i class="now-ui-icons files_box"></i>
            <p> {{ __("Books") }} </p>
          </a>
        </li>

        <li class="@if ($activePage == 'batch') active @endif">
          <a href="{{ route('batch') }}">
            <i class="now-ui-icons education_hat"></i>
            <p> {{ __("Batch") }} </p>
          </a>
        </li>
        <li class="@if ($activePage == 'students') active @endif">
          <a href="{{ route('students') }}">
            <i class="now-ui-icons users_single-02"></i>
            <p> {{ __("Students") }} </p>
          </a>
        </li>
             <li class="@if ($activePage == 'client') active @endif">
          <a href="{{ route('client') }}">
            <i class="now-ui-icons users_single-02"></i>
            <p> {{ __("Client") }} </p>
          </a>
        </li>
  @endif

  @if(Auth::user()->Role == 2)
  <li class="@if ($activePage == 'yearbook') active @endif">
          <a href="{{ route('yearbook') }}">
            <i class="now-ui-icons education_hat"></i>
            <p> {{ __("YearBook") }} </p>
          </a>
        </li>

  @endif

      <li class="@if ($activePage == 'profile') active @endif">
          <a href="{{ route('profile.edit') }}">
            <i class="now-ui-icons users_single-02"></i>
            <p> {{ __("User Profile") }} </p>
          </a>
        </li>
  @if(Auth::user()->Role==0)
        
  <li class="@if ($activePage == 'batch') active @endif">
    <a href="{{ route('batch') }}">
      <i class="now-ui-icons education_hat"></i>
      <p> {{ __("Batch") }} </p>
    </a>
  </li>

    <li class="@if ($activePage == 'section') active @endif">
          <a href="{{ route('section') }}">
            <i class="now-ui-icons design_bullet-list-67"></i>
            <p> {{ __("Section") }} </p>
          </a>
        </li>
       

        <li class="@if ($activePage == 'books') active @endif">
          <a href="{{ route('books') }}">
            <i class="now-ui-icons files_box"></i>
            <p> {{ __("Books") }} </p>
          </a>
        </li>


        <li class="@if ($activePage == 'client') active @endif">
          <a href="{{ route('client') }}">
            <i class="now-ui-icons users_single-02"></i>
            <p> {{ __("Client") }} </p>
          </a>
        </li>


        <li class="@if ($activePage == 'instructor') active @endif">
          <a href="{{ route('instructor') }}">
            <i class="now-ui-icons users_circle-08"></i>
            <p> {{ __("Instructor") }} </p>
          </a>
        </li>

      

        <li class="@if ($activePage == 'users') active @endif">
          <a href="{{ route('users') }}">
            <i class="now-ui-icons users_single-02"></i>
            <p> {{ __("User Management") }} </p>
          </a>
        </li>
      
  @endif


      
    

 
 
    </ul>
  </div>
</div>

@if(session()->has('VerifiedSuccessfully'))
<script>
    swal("Successful!", "Your account has been verified successfully!", "success");
  </script>
@endif
@if(Auth::user()->vrfy == 0)
<!-- Button trigger modal -->

@if(session()->has('codenotmatch'))
<script>
swal("Incorrect Code!", "You have entered an incorrect pin code", "error");
</script>
@endif


<script>
$(document).ready(function(){

$('#Verify').click();
})



</script>


<!-- Button trigger modal -->
<button type="button" class="btn btn-primary d-none"  id="Verify" data-toggle="modal" data-target="#exampleModal">
 
</button>

<!-- Modal -->
<div class="modal  fade bd-example-modal-xl" data-backdrop="true"  id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl  " role="document">
    <div class="modal-content modal-backdrop bg-white">
     
      <div class="modal-body p-5 ">
        @if(session()->has('verifying'))
        <h5>We have sent your OTP (One Time Pin) to verify your Account</h5>
        <h6>Please check your email for incoming message..</h6>
        <form action="{{route('checkverify')}}" method="post">
         @csrf
         <input type="number" name="code" required class="form-control" style="text-align: center;font-size:25px;font-weight:bold">
         <button type="submit" class="btn btn-success mt-2 " style="float: right;">Submit</button>
      </form>
         @else 
         <div style="text-align: center">
             <h5 class="modal-title text-danger" id="staticBackdropLabel">You are not verified yet..</h5>
 
             <h6>
                 Please Verify your Account First to Continue.
 
               </h6>
               Click <button onclick="window.location.href='{{route('verifynow')}}' " class="btn btn-link text-primary">HERE</button> to verify
 
         </div>
       
         @endif
      
      </div>
   
    </div>
  </div>
</div>


@endif