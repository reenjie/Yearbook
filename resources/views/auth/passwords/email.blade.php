@extends('layouts.app', [
    'namePage' => 'Reset Password',
    'class' => 'login-page sidebar-mini ',
    'activePage' => '',
    'backgroundImage' => "https://media.istockphoto.com/id/1058002246/photo/backside-graduation-hats-during-commencement-success-graduates-of-the-university-concept.jpg?s=612x612&w=0&k=20&c=C-GulaMj8L1mbX4cZraquGchW4SXRsiqkFKgjTstGOk=",
])

@section('content')
    <div class="content">
        <div class="container">
            <div class="col-md-4 ml-auto mr-auto">
                <form role="form" method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div class="card card-login card-plain">
                        <div class="card-header ">
                            <div class="logo-container">
                                <img src="https://cdn.pixabay.com/photo/2014/04/03/10/43/graduation-cap-311248_640.png" alt="">
                            </div>
                        </div>
                        <div class="card-body ">
                            <div class="card-body">
                                @if (session('status'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session('status') }}
                                    </div>
                                @endif

                                @if(session('reset'))
                                <div class="alert alert-warning" role="alert">
                                 Reset link was Send Successfully. Please check your email and click the link to reset your password.
                                </div>
                                @endif

                                
                            </div>
                            <div class="input-group no-border form-control-lg {{ $errors->has('email') ? ' has-danger' : '' }}">
                                <span class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="now-ui-icons users_circle-08"></i>
                                    </div>
                                </span>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            </div>
                            @error('email')
                                <span style="display:block;" class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="card-footer ">
                            <button  type = "submit" class="btn btn-primary btn-round btn-lg btn-block mb-3">{{ __('Send Password Reset Link') }}</button>
                        </div>
                    </div>
                </form>
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