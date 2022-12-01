@extends('layouts.app', [
    'namePage' => 'Register page',
    'activePage' => 'register',
    'backgroundImage' => "https://media.istockphoto.com/id/968383368/photo/congratulated.jpg?s=612x612&w=0&k=20&c=cn6bbtt614Ic-txbOghdvmFg0X5WEGXwsz85z3IyUws=",
])

@section('content')
  <div class="content">
    <div class="container">
      <div class="row">
        <div class="col-md-5 ml-auto text-light" >
         <img src="{{asset('assets/img/sidebgreg.png')}}" style="width:100%" alt="">
         <br>
         <h5>
         A Journey Worth Remembering!
         </h5>
         <h6>
         Treasure your High School Memories!!!
         </h6>
        </div>
        <!--  -->
        <div class="col-md-7 mr-auto">
          <div class="card card-signup text-center">
            <div class="card-header ">
              <h4 class="card-title">{{ __('Register') }}</h4>
             
            </div>
            <div class="card-body ">
              @if(session()->has('error'))
            <div class="alert alert-danger">
              {{session()->get('error')}}
            </div>
              @endif
              <form method="POST" action="{{ route('register') }}">
                @csrf
                <!--Begin input name -->

                <div class="row">
                <div class="col-md-12">
                <div class="input-group {{ $errors->has('StudentID') ? ' has-danger' : '' }}">
                  <div class="input-group-prepend">
                    <div class="input-group-text">
                      <i class="now-ui-icons users_circle-08"></i>
                    </div>
                  </div>
                  <input class="form-control {{ $errors->has('StudentID') ? ' is-invalid' : '' }}" placeholder="{{ __('Student ID') }}" type="text" name="StudentID" value="{{ old('StudentID') }}" required autofocus>
                  @if ($errors->has('StudentID'))
                    <span class="invalid-feedback" style="display: block;" role="alert">
                      <strong>{{ $errors->first('StudentID') }}</strong>
                    </span>
                  @endif
                </div>

                        </div>
                      
                  <div class="col-md-4">
                  <div class="input-group {{ $errors->has('Firstname') ? ' has-danger' : '' }}">
                  <div class="input-group-prepend">
                    <div class="input-group-text">
                      <i class="now-ui-icons users_circle-08"></i>
                    </div>
                  </div>
                  <input class="form-control {{ $errors->has('Firstname') ? ' is-invalid' : '' }}" placeholder="{{ __('First Name') }}" type="text" name="Firstname" value="{{ old('Firstname') }}" required autofocus>
                  @if ($errors->has('Firstname'))
                    <span class="invalid-feedback" style="display: block;" role="alert">
                      <strong>{{ $errors->first('Firstname') }}</strong>
                    </span>
                  @endif
                </div>
                  </div>
                  <div class="col-md-4">
  
                  <div class="input-group {{ $errors->has('Middlename') ? ' has-danger' : '' }}">
                  <div class="input-group-prepend">
                    <div class="input-group-text">
                      <i class="now-ui-icons users_circle-08"></i>
                    </div>
                  </div>
                  <input class="form-control {{ $errors->has('Middlename') ? ' is-invalid' : '' }}" placeholder="{{ __('Middlename') }}" type="text" name="Middlename" value="{{ old('Middlename') }}" required autofocus>
                  @if ($errors->has('Middlename'))
                    <span class="invalid-feedback" style="display: block;" role="alert">
                      <strong>{{ $errors->first('Middlename') }}</strong>
                    </span>
                  @endif
                </div>
                  </div>

                  <div class="col-md-4">
  
                  <div class="input-group {{ $errors->has('Lastname') ? ' has-danger' : '' }}">
                  <div class="input-group-prepend">
                    <div class="input-group-text">
                      <i class="now-ui-icons users_circle-08"></i>
                    </div>
                  </div>
                  <input class="form-control {{ $errors->has('Lastname') ? ' is-invalid' : '' }}" placeholder="{{ __('Lastname') }}" type="text" name="Lastname" value="{{ old('Lastname') }}" required autofocus>
                  @if ($errors->has('Lastname'))
                    <span class="invalid-feedback" style="display: block;" role="alert">
                      <strong>{{ $errors->first('Lastname') }}</strong>
                    </span>
                  @endif
                </div>
                  </div>

                  <div class="col-md-6">
  
                  <div class="input-group {{ $errors->has('Sex') ? ' has-danger' : '' }}">
                  <div class="input-group-prepend">
                    <div class="input-group-text">
                      <i class="now-ui-icons users_circle-08"></i>
                    </div>
                  </div>
                  <select name="Sex" id="" class="form-control">
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                  </select>
                 
                  @if ($errors->has('Sex'))
                    <span class="invalid-feedback" style="display: block;" role="alert">
                      <strong>{{ $errors->first('Sex') }}</strong>
                    </span>
                  @endif
                </div>
                  </div>

                  <div class="col-md-6">
                  <div class="input-group {{ $errors->has('Batch') ? ' has-danger' : '' }}">
                  <div class="input-group-prepend">
                    <div class="input-group-text">
                      <i class="now-ui-icons users_circle-08"></i>
                    </div>
                  </div>
                  @php
                    $batch = DB::select('select * from batches');

                  @endphp
                    <select required name="Batch" id="" class="form-control">
                      <option value="">Select Batch</option>
                      @foreach($batch as $b)
                    <option value="{{$b->id}}">{{$b->Name}}</option>
                      @endforeach
                    </select>
                  @if ($errors->has('Batch'))
                    <span class="invalid-feedback" style="display: block;" role="alert">
                      <strong>{{ $errors->first('Batch') }}</strong>
                    </span>
                  @endif
                </div>
                  </div>
                </div>

        




             

                <div class="input-group {{ $errors->has('Section') ? ' has-danger' : '' }}">
                  <div class="input-group-prepend">
                    <div class="input-group-text">
                      <i class="now-ui-icons users_circle-08"></i>
                    </div>
                  </div>
                  @php
                    $section = DB::select('select * from sections');

                  @endphp
                    <select required name="Section" id="" class="form-control">
                      <option value="">Select Section</option>
                      @foreach($section as $s)
                    <option value="{{$s->id}}">{{$s->Name}}</option>
                      @endforeach
                    </select>
                  
                  @if ($errors->has('Section'))
                    <span class="invalid-feedback" style="display: block;" role="alert">
                      <strong>{{ $errors->first('Section') }}</strong>
                    </span>
                  @endif
                </div>
                <!--Begin input email -->
                <div class="input-group {{ $errors->has('email') ? ' has-danger' : '' }}">
                  <div class="input-group-prepend">
                    <div class="input-group-text">
                      <i class="now-ui-icons ui-1_email-85"></i>
                    </div>
                  </div>
                  <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ __('Email') }}" type="email" name="email" value="{{ old('email') }}" required>
                 </div>
                 @if ($errors->has('email'))
                    <span class="invalid-feedback" style="display: block;" role="alert">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
                <!--Begin input user type-->
                
                <!--Begin input password -->
                <div class="input-group {{ $errors->has('password') ? ' has-danger' : '' }}">
                  <div class="input-group-prepend">
                    <div class="input-group-text">
                      <i class="now-ui-icons objects_key-25"></i>
                    </div>
                  </div>
                  <input class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="{{ __('Password') }}" type="password" name="password" required>
                  @if ($errors->has('password'))
                    <span class="invalid-feedback" style="display: block;" role="alert">
                      <strong>{{ $errors->first('password') }}</strong>
                    </span>
                  @endif
                </div>
                <!--Begin input confirm password -->
                <div class="input-group">
                  <div class="input-group-prepend">
                    <div class="input-group-text">
                      <i class="now-ui-icons objects_key-25"></i></i>
                    </div>
                  </div>
                  <input class="form-control" placeholder="{{ __('Confirm Password') }}" type="password" name="password_confirmation" required>
                </div>
                <div class="form-check text-left">
                  <label class="form-check-label">
                    <input class="form-check-input" type="checkbox">
                    <span class="form-check-sign"></span>
                    {{ __('I agree to the') }}
                    <a href="#something">{{ __('terms and conditions') }}</a>.
                  </label>
                </div>
                <div class="card-footer ">
                  <button type="submit" class="btn btn-primary btn-round btn-lg">{{__('Get Started')}}</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('js')
  <script>
    $(document).ready(function() {
      demo.checkFullPageBackgroundImage();
    });
  </script>
@endpush
