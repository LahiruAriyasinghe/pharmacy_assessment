@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{$hospital->name . ' - Create new user' }}</div>

                <div class="card-body">
                    <form id="user_form" method="POST" action="{{ route('users.store') }}" class="needs-validation" novalidate>
                        @csrf

                        <input type="hidden" name="hospital" id="hospital_id" value="{{$hospital->id}}">
                        <input type="hidden" id="email_check_url" value="{{route('users.email.check')}}">
                        <input type="hidden" id="username_check_url" value="{{route('users.username.check')}}">

                        <div class="form-group row">
                            <label for="title" class="col-md-4 col-form-label text-md-right">Title</label>

                            <div class="col-md-2">
                                <select class="form-control" id="title" name="title">
                                    <option selected>Mr</option>
                                    <option>Miss</option>
                                    <option>Mrs</option>
                                    <option>Dr</option>
                                  </select>    
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="first_name" class="col-md-4 col-form-label text-md-right">Name</label>

                            <div class="col-md-3">
                                <input id="first_name" type="text" class="form-control" name="first_name" required autofocus>
    
                            </div>
                            <div class="col-md-3">
                                <input id="last_name" type="text" class="form-control" name="last_name">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="username" class="col-md-4 col-form-label text-md-right">Username</label>

                            <div class="col-md-6">
                                <input id="username" type="text" class="form-control" name="username">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="contact" class="col-md-4 col-form-label text-md-right">Contact</label>

                            <div class="col-md-6">
                                <input id="contact" type="text" class="form-control" name="contact" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="gender" class="col-md-4 col-form-label text-md-right">Gender</label>

                            <div class="col-md-3">
                                <select class="form-control" id="gender" name="gender">
                                    <option value="M" selected>Male</option>
                                    <option value="F">Female</option>
                                    <option value="O">Other</option>
                                  </select>    
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="role" class="col-md-4 col-form-label text-md-right">Role</label>

                            <div class="col-md-4">
                                <select class="form-control" id="role" name="role">
                                    @foreach ($roles as $role)
                                        <option value="{{$role->id}}">{{substr($role->name, strpos($role->name, "-") + 1)}}</option>                                        
                                    @endforeach
                                  </select> 
                            </div>

                            <div class="col-md-4 custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="is_doctor" name="is_doctor">
                                <label class="custom-control-label" for="is_doctor">Doctor</label>
                              </div>
                        </div>

                        <hr class="when-doctor">

                        <div class="form-group row when-doctor">
                            <label for="specialty" class="col-md-4 col-form-label text-md-right">Specility</label>

                            <div class="col-md-6">
                                <select class="form-control" id="specialty" name="specialty">
                                    @foreach ($specialties as $specialty)
                                        <option value="{{$specialty->id}}">{{$specialty->acronym}} - {{$specialty->name}}</option>                                        
                                    @endforeach
                                  </select> 
                            </div>
                        </div>

                        <div class="form-group row when-doctor">
                            <label for="note" class="col-md-4 col-form-label text-md-right">Note (optional)</label>

                            <div class="col-md-6">
                                <textarea class="form-control" id="note" rows="3" name="note"></textarea>
                            </div>
                        </div>
                        
                        <div class="form-group row when-doctor">
                            <label for="fee" class="col-md-4 col-form-label text-md-right">Doctor Fee</label>

                            <div class="col-md-6">
                                <input id="fee" type="text" class="form-control" name="fee">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Create
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
<script src="https://unpkg.com/imask"></script>
<script src="{{asset('js/users/create.js')}}"></script>
@endpush

@push('styles')

@endpush