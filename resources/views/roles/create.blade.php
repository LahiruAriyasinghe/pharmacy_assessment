@extends('layouts.app')

@section('title', 'Add Role')

@section('content')

{{-- <style>
    .row{
        width: 100%;
    }
</style> --}}

<div class="container">
    <div class="page-title-btn">
        <div class="page-title-with-button">
            <span>
                <img class="page-title-icon" src="{{ asset('img/role.svg') }}">
            </span>Add New Role
        </div>
    </div>
    <hr>
</div>

<div class="container">
    <div class="row">
        <div class="col-12">
            <form action="{{route('roles.store')}}" method="post" id="role_form">
                @csrf
                <div class="form-group row">
                    <label for="role_name" class="col-md-4 col-form-label text-md-right">Role Name</label>

                    <div class="col-md-4">
                        <input id="role_name" type="text" class="form-control" name="role_name" required>
                    </div>
                </div>
                <hr>
                <div class="row my-4">

                    @foreach ($permissions as $key => $subPermissions)                                        
                    <div class="col-lg-6 col-sm-12">
                        <div class="permisions-role-card shadow-sm">
                            <div class="permisions-role-card-top">
                                <div class="permisions-title-highlight">{{ Illuminate\Support\Str::upper($key)}}<span
                                        class="permisions-role-card-title">Permission</span>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input permission-category" type="checkbox" value="{{$key}}" id="permission-{{Illuminate\Support\Str::kebab($key)}}">
                                    <label class="custom-control-label" for="permission-{{Illuminate\Support\Str::kebab($key)}}">
                                        Select All
                                    </label>
                                </div>
                            </div>
                            <div class="permisions-role-card-input">
                                <div class="row pl-3">
    
                                    @foreach ($subPermissions as $permission)
                                    <div class="col-lg-6 col-md-12 custom-control custom-checkbox">
                                        <input type="checkbox" class="permission-{{Illuminate\Support\Str::kebab($key)}} custom-control-input permission" id="role_permissions_{{$permission->id}}"
                                            name="role_permissions[]" value="{{$permission->id}}">
                                        <label class="custom-control-label"
                                            for="role_permissions_{{$permission->id}}">{{ Illuminate\Support\Str::title($permission->name)}}</label>
                                    </div>
                                    @endforeach
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach    
                </div>
                
                <div class="form-group mt-5 d-flex justify-content-end">
                    <button type="button" class="btn btn-secondary mr-2" onclick="window.history.back()">Close</button>
                <button type="button" id="new_role_save_btn" class="btn btn-primary">Save and Add</button>
                </div>
            </form>

            
        </div>
    </div>
</div>


@endsection

@push('scripts')
<script src="https://unpkg.com/imask"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script src="{{asset('js/roles/create.js')}}"></script>
@endpush