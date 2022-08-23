@extends('layouts.app_auth')

@section('title',  __('Login'))

@section('content')
<div class="container">
    <div class="row my-4">
        <!-- <div class="col-md-5 no-gutters no-padding ">
            <img class="login-img" style="width: 100%;" src="{{ asset('img/login-w.jpg') }}">
        </div> -->
        <div class="col-lg-8 offset-lg-2 col-md-12 w-100 login-card shadow-sm no-gutters no-padding">
            <div class="">
                <div class="card-body">
                    <div class="d-flex justify-content-center">
                        <img class="login-logo-img" src="{{ asset('img/logo.png') }}" />
                    </div>
                    <div class="login-hospital-title">{{ __('Login') }}</div>

                    <form method="POST" action="{{ route('login.custom') }}">
                        @csrf
                        <div class="form-group row justify-content-center">
                            <div class="col-md-8 col-sm-12">
                                <input type="text" placeholder="Email" id="email" class="form-control form-control-text" name="email" required
                                    autofocus>
                                @if ($errors->has('email'))
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row justify-content-center">
                            <div class="col-md-8 col-sm-12">
                                <input type="password" placeholder="Password" id="password" class="form-control form-control-text" name="password" required>
                                @if ($errors->has('password'))
                                <span class="text-danger">{{ $errors->first('password') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row justify-content-center">
                        <div class="col-md-8 col-sm-12">
                            <div class="d-grid mx-auto mb-2">
                                <button type="submit" class="btn btn-primary w-100 login-btn-font mb-2">{{ __('Login') }}</button>
                            </div>
                            <a class="btn btn-link" href="{{ route('register-user') }}">
                                    Don't you have a account? create account
                            </a>
                        </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row justify-content-center">
        <h3 class="footer-quote">Your Health is Our Priority</h3>
    </div>
</div>
@endsection