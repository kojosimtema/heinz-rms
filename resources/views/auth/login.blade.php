@extends('layouts.frontend.heinz')

@section('content')
<div class="wrapper-page">
    <div class=" card-box">
        <div class="panel-heading">
            <h3 class="text-center" style="color: #d46c21;"><?php echo env('ASSEMBLY_SMS_NAME'); ?> </h3>


        </div>


        <div class="panel-body">
            <form class="form-horizontal m-t-20" action="{{ route('login') }}" method="post" data-parsley-validate novalidate>
                @csrf
                <div class="form-group ">
                    <div class="col-xs-12">
                        <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" type="email" required placeholder="Email Address" name="email" value="{{ old('email') }}">
                        @if ($errors->has('email'))
                            <small class="invalid-feedback">
                                <strong style="color:red;">{{ $errors->first('email') }}</strong>
                            </small>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-xs-12">
                        <input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" type="password" required name="password" placeholder="Password">
                        @if ($errors->has('email'))
                            <small class="invalid-feedback">
                                <strong style="color:red;">{{ $errors->first('email') }}</strong>
                            </small>
                        @endif
                    </div>
                </div>

                <div class="form-group ">
                    <div class="col-xs-12">
                        <div class="checkbox checkbox-primary">
                            <input id="checkbox-signup" type="checkbox" {{ old('remember') ? 'checked' : '' }}  name="remember" >
                            <label for="checkbox-signup">
                                {{ __('Remember me') }}
                            </label>
                        </div>

                    </div>
                </div>

                <div class="form-group text-center m-t-40">
                    <div class="col-xs-12">
                        <button class="btn btn-block text-uppercase waves-effect waves-light"style="background: #d46c21; color:#fff;" type="submit">{{ __('Login') }}</button>
                    </div>
                </div>

                <div class="form-group m-t-30 m-b-0">
                    <div class="col-sm-12">
                        <a href="" class="text-dark"><i class="fa fa-lock m-r-5"></i> {{ __('Forgot password?') }}</a>
                    </div>
                </div>
            </form>

        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 text-center">
            <!-- <p>Don't have an account? <a href="#" class="text-primary m-l-5"><b>{{ __('Sign up') }}</b></a></p> -->

        </div>
    </div>
</div>
@endsection
