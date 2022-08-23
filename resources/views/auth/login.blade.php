@extends('layouts.app')

@section('title', $hospital->name . ' ' . __('Login'))

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
                    <div class="login-hospital-title">{{$hospital->name . ' ' . __('Login') }}</div>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <input type="hidden" name="hospital_id" value="{{$hospital->id}}">

                        <div class="form-group row justify-content-center">
                            <!-- <label for="username" class="col-md-4 col-form-label text-md-right">Username</label> -->

                            <div class="col-md-8 col-sm-12">
                                <input id="username" type="text" placeholder="Username"
                                    class="form-control-text form-control @error('username') is-invalid @enderror"
                                    name="username" value="{{ old('username') }}" required autocomplete="email"
                                    autofocus>

                                @error('username')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row justify-content-center">
                            <!-- <label for="password" class="col-md-4 col-form-label text-md-right">Password</label> -->

                            <div class="col-md-8 col-sm-12">
                                <input id="password" type="password" placeholder="Password"
                                    class="form-control-text form-control @error('password') is-invalid @enderror"
                                    name="password" required autocomplete="current-password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row justify-content-center">
                            <div class="col-md-8 col-sm-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                        {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0 justify-content-center mb-5">
                            <div class="col-md-8 col-sm-12">
                                <button type="submit" class="btn btn-primary w-100 login-btn-font mb-2">
                                    {{ __('Login') }}
                                </button>
                                <a class="btn btn-link" href="{{ route('pharmacy.register') }}">
                                    {{ __('Don\'t you have an account? Create an Account') }}
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