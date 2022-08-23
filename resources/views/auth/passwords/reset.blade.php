@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Reset Password') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        @if(Session::has('error'))
                        <div class="alert alert-danger">
                            {{ Session::get('error')}}
                        </div>
                        @endif

                        <div class="form-group row">
                            <label for="old-password" class="col-md-4 col-form-label text-md-right">Old Password</label>

                            <div class="col-md-6">
                                <input id="old-password" type="password"
                                    class="form-control @error('old_password') is-invalid @enderror" name="old_password"
                                    value="{{ $old_password ?? old('old_password') }}" autocomplete="off" autofocus>

                                @error('old_password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <br>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">New Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    autocomplete="new-password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm"
                                class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control"
                                    name="password_confirmation" autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="offset-md-4 col-md-6 custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input"
                                onclick="showPassword()" id="show-password">
                                <label class="custom-control-label ml-3"
                                    for="show-password">Show Password</label>
                            </div>
                        </div>


                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Reset Password') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function showPassword() {
        var oldpw = document.getElementById("old-password");
        var pw = document.getElementById("password");
        var pwcnfm = document.getElementById("password-confirm");

        if (oldpw.type === "password") {
            oldpw.type = "text";
            pw.type = "text";
            pwcnfm.type = "text";
        } else {
            oldpw.type = "password";
            pw.type = "password";
            pwcnfm.type = "password";
        }
    }
</script>
@endpush