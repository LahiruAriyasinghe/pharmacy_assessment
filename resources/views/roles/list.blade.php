@extends('layouts.app')

@section('title', 'Manage User Roles')

@section('content')
<div class="container">
    <div class="page-title-btn">
        <div class="page-title-with-button"><span><img class="page-title-icon"
                    src="{{ asset('img/role.svg') }}"></span>{{$hospital->name}} User Roles</div>
        @can('create role', App\User::class)
        <Button type="button" class="btn btn-primary" onclick="createRole()">Add New
            Role</Button>
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
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>

            </table>
        </div>
    </div>
</div>

<!-- Modal Add New User-->
<div class="modal fade" id="new_role_model" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
    aria-labelledby="new_role_model" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New User Role</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="">
                    <form action="{{route('roles.store')}}" method="post" id="role_form">
                        <div class="form-group row">
                            <label for="role_name" class="col-md-4 col-form-label text-md-right">Role Name</label>

                            <div class="col-md-6">
                                <input id="role_name" type="text" class="form-control" name="role_name" required>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row user-role-padding">
                            @foreach ($permissions as $permission)
                            <div
                                class="@if($permission->id < 36) col-md-3 @else col-md-12 @endif custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input"
                                    id="role_permissions_{{$permission->id}}" name="role_permissions[]"
                                    value="{{$permission->id}}">
                                <label class="custom-control-label"
                                    for="role_permissions_{{$permission->id}}">{{ Str::title($permission->name)}}</label>
                            </div>
                            @endforeach
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" id="new_role_save_btn" class="btn btn-primary">Save and Add</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Add New User Role-->

<!-- Modal Edit User Role-->
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
<!-- Modal Edit User Role-->

<form id="delete_user_form" action="{{route('roles.destroy', ['role'=>'xx'])}}" method="post">
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
<script src="{{asset('js/roles/create.js')}}"></script>
<script>
var table = null;

$(document).ready(function() {

    table = $('#user_table').DataTable({
        "ajax": "{{route('resources.roles.index')}}",
        "columns": [{
                "data": "short_name"
            },
            {
                "data": "create"
            },
            {
                "data": null
            },
        ],
        "columnDefs": [{
                targets: [2],
                orderable: false
            },
            {
                "targets": -1,
                "data": null,
                "render": function(data, type, row, meta) {
                    let editBtn = '';
                    let deleteBtn = '';

                    @can('edit role', App\ User::class)
                    editBtn = `<a type="button" class="btn btn-secondary edit-btn"
                                onclick="editRole(${data.id})">Edit</a>`;
                    @endcan

                    @can('delete role', App\ User::class)
                    deleteBtn = `<a type="button" class="btn btn-danger delete-btn"
                                onclick="deleteRole(${data.id}, '${data.short_name}')">Delete</a>`;
                    @endcan

                    if (data.short_name == 'admin') {
                        deleteBtn = '';
                    }

                    return `${editBtn} ${deleteBtn}`;
                }
            },
        ],
    });
});

function createRole() {
    let url = "{{route('roles.create')}}";
    window.location.href = url;
}

function editRole(roleId) {
    let url = "{{route('roles.edit', ['role' => 'xx'])}}";
    window.location.href = url.replace("xx", roleId);
}

function deleteRole(roleId, name) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        confirmButtonText: 'Yes, delete ' + name
    }).then((result) => {
        if (result.value) {
            deleteRequest(roleId, name);
        }
    })
}

function deleteRequest(roleId, name) {
    let form = $("#delete_user_form");

    $.ajax({
        type: "DELETE",
        url: form.attr("action").replace("xx", roleId),
        data: form.serialize(),
        success: function(response) {
            console.log(response);

            if ("success" in response) {
                Swal.fire({
                    title: 'Deleted!',
                    text: name + ' has been deleted.',
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
                text: response.msg,
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

.user-role-padding {
    padding: 20px !important;
}
</style>
@endpush