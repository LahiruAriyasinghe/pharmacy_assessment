@extends('layouts.app')

@section('title', 'Manage Users')

@section('content')
<div class="container">
    <div class="page-title-btn">
        <div class="page-title-with-button"><span><img class="page-title-icon"
                    src="{{ asset('img/group.svg') }}"></span>{{$hospital->name}} Users</div>

        @can('create user', App\User::class)
        <Button type="button" class="btn btn-primary" data-toggle="modal" data-target="#new_user_model">Add New
            User</Button>
        @endcan

    </div>
    <hr>
</div>

<div class="container">

    <div class="row">
        <div class="col-12">
            <table id="user_table" class="table table-bordered hover" style="width:100%">
                <thead>
                    <tr class="table-title">
                        <th>Name</th>
                        <th>Role</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>

            </table>
        </div>
    </div>
</div>

<!-- Modal Add New User-->
<div class="modal fade" id="new_user_model" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
    aria-labelledby="new_user_model" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="">
                    <form id="user_form" method="POST" action="{{ route('users.store') }}" class="needs-validation"
                        novalidate>
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
                                <input id="first_name" type="text" class="form-control" name="first_name" required
                                    autofocus>

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
                                    <option value="{{$role->id}}">{{substr($role->name, strpos($role->name, "-") + 1)}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                        </div>

                        <div class="form-group row">

                            <div class="col-md-2 offset-md-4 custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="is_doctor" name="is_doctor">
                                <label class="custom-control-label ml-3" for="is_doctor">Doctor</label>
                            </div>

                            <div class="col-md-2 custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="is_nurse" name="is_nurse">
                                <label class="custom-control-label" for="is_nurse">Nurse</label>
                            </div>

                            <div class="col-md-2 custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="is_mlt" name="is_mlt">
                                <label class="custom-control-label" for="is_mlt">MLT</label>
                            </div>
                        </div>

                        <hr class="when-doctor">

                        <div class="form-group row when-doctor">
                            <label for="specialty" class="col-md-4 col-form-label text-md-right">Specility</label>

                            <div class="col-md-6">
                                <select class="form-control" id="specialty" name="specialty">
                                    @foreach ($specialties as $specialty)
                                    <option value="{{$specialty->id}}">{{$specialty->acronym}} - {{$specialty->name}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row when-doctor">
                            <label for="note" class="col-md-4 col-form-label text-md-right">Note (Optional)</label>

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
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" id="new_user_save_btn" class="btn btn-primary">Save and Add</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Add New User-->

<!-- Modal Edit User-->
<div class="modal fade" id="editUser" tabindex="-1" role="dialog" aria-labelledby="editUser" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUser">Edit user</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save Changes</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Edit User-->

<form id="delete_user_form" action="{{route('users.destroy', ['user'=>'xx'])}}" method="post">
    @csrf
    @method('DELETE')
</form>

@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
<script src="https://unpkg.com/imask"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script src="{{asset('js/users/create.js')}}"></script>
<script>
var table = null;

$(document).ready(function() {

    table = $('#user_table').DataTable({
        "ajax": "{{route('resources.users.index')}}",
        "columns": [{
                "data": "full_name"
            },
            {
                "data": "role_name"
            },
            {
                "data": "username"
            },
            {
                "data": "email"
            },
            {
                "data": "created_at"
            },
            {
                "data": null
            },
        ],
        "columnDefs": [{
                targets: [3, 4, 5],
                orderable: false
            },
            {
                "targets": -1,
                "data": null,
                "render": function(data, type, row, meta) {
                    let editBtn = '';
                    let deleteBtn = '';

                    @can('edit user', App\ User::class)
                    editBtn = `<a type="button" class="btn btn-secondary edit-btn"
                                onclick="editUser(${data.id})">Edit</a>`;
                    @endcan

                    @can('delete user', App\ User::class)
                    deleteBtn = `<a type="button" class="btn btn-danger delete-btn"
                                onclick="deleteUser(${data.id}, '${data.username}')">Delete</a>`;
                    @endcan

                    if (data.role_name == 'admin') {
                        deleteBtn = '';
                    }

                    return `${editBtn} ${deleteBtn}`;
                }
            },
        ],
    });
});

function editUser(userId) {
    console.log('userId :>> ', userId);
    let url = "{{route('users.edit', ['user' => 'xx'])}}";

    window.location.href = url.replace("xx", userId);
}

function deleteUser(userId, username) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        confirmButtonText: 'Yes, delete ' + username
    }).then((result) => {
        if (result.value) {
            deleteRequest(userId, username);
        }
    })
}

function deleteRequest(userId, username) {
    let form = $("#delete_user_form");

    $.ajax({
        type: "DELETE",
        url: form.attr("action").replace("xx", userId),
        data: form.serialize(),
        success: function(response) {
            console.log(response);

            if ("success" in response) {
                Swal.fire({
                    title: 'Deleted!',
                    text: username + ' has been deleted.',
                    icon: 'success',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                }).then((result) => {
                    if (result.value) {
                        table.ajax.reload();
                    }
                })
                return;
            }

            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Something went wrong!',
            });
            return;
        },
        error: function(request, status, error) {
            console.error("error :>> ", request.responseText);
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Something went wrong!',
            });
            return;
        },
    });
}
</script>
@endpush

@push('styles')
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css"> -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
<style>
.btn-secondary {
    color: #fff !important;
}

.btn-danger {
    color: #fff !important;
}
</style>
@endpush