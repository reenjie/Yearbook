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

        <li class="@if ($activePage == 'section') active @endif">
          <a href="{{ route('section') }}">
            <i class="now-ui-icons design_bullet-list-67"></i>
            <p> {{ __("Section") }} </p>
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
