@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{$hospital->name . ' - Create new user' }}</div>

                <div class="card-body">
                    <form id="user_form" method="POST" action="{{ route('users.update', $user) }}"
                        class="needs-validation" novalidate>
                        @csrf
                        @method('PUT')

                        <input type="hidden" name="hospital" value="{{$hospital->id}}">
                        <input type="hidden" id="user_id" value="{{$user->id}}">
                        <input type="hidden" id="email_check_url" value="{{route('users.email.check')}}">
                        <input type="hidden" id="username_check_url" value="{{route('users.username.check')}}">

                        <div class="form-group row">
                            <label for="title" class="col-md-4 col-form-label text-md-right">Title</label>

                            <div class="col-md-2">
                                <select class="form-control" id="title" name="title">
                                    <option value="Mr" @if ($user->title == 'Mr') selected @endif>Mr</option>
                                    <option value="Miss" @if ($user->title == 'Miss') selected @endif>Miss</option>
                                    <option value="Mrs" @if ($user->title == 'Mrs') selected @endif>Mrs</option>
                                    <option value="Dr" @if ($user->title == 'Dr') selected @endif>Dr</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="first_name" class="col-md-4 col-form-label text-md-right">Name</label>

                            <div class="col-md-3">
                                <input id="first_name" type="text" class="form-control" name="first_name"
                                    value="{{$user->first_name}}" required autofocus>

                            </div>
                            <div class="col-md-3">
                                <input id="last_name" type="text" class="form-control" name="last_name"
                                    value="{{$user->last_name}}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="username" class="col-md-4 col-form-label text-md-right">Username</label>

                            <div class="col-md-6">
                                <input id="username" type="text" class="form-control" name="username"
                                    value="{{$user->username}}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email"
                                    value="{{$user->email}}" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="contact" class="col-md-4 col-form-label text-md-right">Contact</label>

                            <div class="col-md-6">
                                <input id="contact" type="text" class="form-control" name="contact"
                                    value="{{$user->contact}}" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="gender" class="col-md-4 col-form-label text-md-right">Gender</label>

                            <div class="col-md-3">
                                <select class="form-control" id="gender" name="gender">
                                    <option value="M" @if ($user->gender == 'M') selected @endif>Male</option>
                                    <option value="F" @if ($user->gender == 'F') selected @endif>Female</option>
                                    <option value="O" @if ($user->gender == 'O') selected @endif>Other</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="role" class="col-md-4 col-form-label text-md-right">Role</label>
                            <div class="col-md-4">
                                <select class="form-control" id="role" name="role">
                                    @php
                                    $roleId = $user->roles()->first()->id;
                                    @endphp
                                    @foreach ($roles as $role)
                                    <option value="{{$role->id}}" @if ($roleId==$role->id) selected @endif>
                                        {{substr($role->name, strpos($role->name, "-") + 1)}}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>

                        <div class="form-group row">
                            <div class="col-md-2 offset-md-4 custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="is_doctor" name="is_doctor"
                                    @if($doctor) checked @endif>
                                <label class="custom-control-label ml-3" for="is_doctor">Doctor</label>
                            </div>

                            <div class="col-md-2 custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="is_nurse" name="is_nurse"
                                    @if($user->nurse) checked @endif>
                                <label class="custom-control-label" for="is_nurse">Nurse</label>
                            </div>

                            <div class="col-md-2 custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="is_mlt" name="is_mlt"
                                    @if($user->mlt) checked @endif>
                                <label class="custom-control-label" for="is_mlt">MLT</label>
                            </div>
                        </div>

                        <hr class="when-doctor">

                        <div class="form-group row when-doctor">
                            <label for="specialty" class="col-md-4 col-form-label text-md-right">Specility</label>

                            <div class="col-md-6">
                                <select class="form-control" id="specialty" name="specialty">
                                    @foreach ($specialties as $specialty)
                                    <option value="{{$specialty->id}}" @if($doctor && ($doctor->specialty_id ==
                                        $specialty->id)) selected @endif>{{$specialty->acronym}} - {{$specialty->name}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row when-doctor">
                            <label for="note" class="col-md-4 col-form-label text-md-right">Note (Optional)</label>

                            <div class="col-md-6">
                                <textarea class="form-control" id="note" rows="3"
                                    name="note">@if($doctor){{$doctor->note}}@endif</textarea>
                            </div>
                        </div>

                        <div class="form-group row when-doctor">
                            <label for="fee" class="col-md-4 col-form-label text-md-right">Doctor Fee</label>

                            <div class="col-md-6">
                                <input id="fee" type="text" class="form-control" name="fee"
                                    value="@if($doctor){{$doctor->fee}}@endif">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="button" class="btn btn-secondary"
                                    onclick="window.history.back()">Close</button>
                                <button type="submit" class="btn btn-primary" id="user_save_btn">
                                    Update User
                                </button>
                            </div>
                        </div>
                    </form>

                    @can('reset user password', App\User::class)
                    <hr>
                    <div class="form-group row">
                        <label for="email" class="col-md-4 col-form-label text-md-right">Reset user password</label>

                        <div class="col-md-6">
                            <button type="button" class="btn btn-secondary" data-toggle="modal"
                                data-target="#resetUserModal">
                                Reset
                            </button>
                        </div>
                    </div>

                    <div class="modal fade" id="resetUserModal" tabindex="-1" role="dialog"
                        aria-labelledby="resetUserModalTitle" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle">Reset {{$user->username}} user
                                        password</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form id="user_reset_form" action="{{route('users.password.reset', $user)}}" method="post" class="needs-validation" novalidate>
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group row">
                                            <label for="admin_password"
                                                class="col-md-4 col-form-label text-md-right">Your Password</label>

                                            <div class="col-md-6">
                                                <input id="admin_password" type="password" class="form-control"
                                                    name="password">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label for="" class="col-md-8 offset-md-4 col-form-label">Note: User
                                                password will change to "password"</label>
                                        </div>
                                        <br>
                                        <div class="form-group row mb-0">
                                            <div class="col-md-6 offset-md-4">
                                                <button type="submit" class="btn btn-primary" id="user_rest_btn">Reset</button>
                                            </div>
                                        </div>
                                    </form>
                                    <br>
                                </div>                                
                            </div>
                        </div>
                    </div>
                    @endcan

                </div>
            </div>
        </div>
    </div>
</div>


@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
<script src="https://unpkg.com/imask"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script src="{{asset('js/users/edit.js')}}"></script>
@endpush

@push('styles')
<style>

</style>
@endpush