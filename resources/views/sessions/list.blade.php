@extends('layouts.app')

@section('title', 'Manage Channeling Sessions')

@section('content')
<div class="container">
    <div class="page-title-btn">
        <div class="page-title-with-button"><span><img class="page-title-icon"
                    src="{{ asset('img/doctor.svg') }}"></span>Channel Sessions</div>
        @can('create session', App\User::class)
        <Button type="button" class="btn btn-primary" data-toggle="modal" data-target="#new_session_model">Add New
            Session</Button>
        @endcan
    </div>
    <hr>
</div>

<div class="container">

    <div class="row">
        <div class="col-12">
            <table id="session_table" class="table table-bordered hover" style="width:100%">
                <thead>
                    <tr class="table-title">
                        <th>Session name</th>
                        <th>Room No</th>
                        <th>Doctor</th>
                        <th>Nurse</th>
                        <th>Day</th>
                        <th>Start At</th>
                        <th>End At</th>
                        <th>Actions</th>
                    </tr>
                </thead>

            </table>
        </div>
    </div>
</div>

<!-- Modal Add New speciality-->
<div class="modal fade" id="new_session_model" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
    aria-labelledby="new_session_model" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Session</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="">
                    <form action="{{route('sessions.store')}}" method="post" id="session_form">
                        @csrf
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">Session Name</label>
                            <div class="col-md-6">
                                <input id="session_name" type="text" class="form-control" name="name" autocomplete="off">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">Room No</label>
                            <div class="col-md-6">
                                <input id="room_no" type="text" class="form-control" name="room_no" autocomplete="off">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Doctor In Charge</label>
                            <div class="col-md-6">
                                <select class="form-control" id="doctor_id" name="doctor_id">
                                    @foreach($doctors as $doctor)
                                    <option value="{{$doctor->doctor->id}}">{{$doctor->first_name}}
                                        {{$doctor->last_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">Nurse In Charge (Optional)</label>
                            <div class="col-md-6">
                                <select class="form-control" id="nurse_id" name="nurse_id">
                                    <option value="">None</option>
                                    @foreach($users as $user)
                                    <option value="{{$user->id}}">{{$user->first_name}} {{$user->last_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">Day of Week</label>
                            <div class="col-md-3">
                                <select class="form-control" id="week_day" name="week_day">
                                    <option value="Monday" selected>Monday</option>
                                    <option value="Tuesday">Tuesday</option>
                                    <option value="Wednesday">Wednesday</option>
                                    <option value="Thursday">Thursday</option>
                                    <option value="Friday">Friday</option>
                                    <option value="Saturday">Saturday</option>
                                    <option value="Sunday">Sunday</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">Start At:</label>
                            <div class="col-md-3">
                                <input id="start_at" type="time" class="form-control" name="start_at">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">End At:</label>
                            <div class="col-md-3">
                                <input id="end_at" type="time" class="form-control" name="end_at">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">Max no of patients</label>
                            <div class="col-md-6">
                                <input id="maximum_patients" type="text" class="form-control" name="maximum_patients"
                                    value="1">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" id="new_session_save_btn" class="btn btn-primary">Save and Add</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Add New speciality-->

<!-- Modal Edit speciality-->
<div class="modal fade" id="editUser" tabindex="-1" role="dialog" aria-labelledby="editUser" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUser">Edit speciality</h5>
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
<!-- Modal Edit speciality-->

<form id="delete_session_form" action="{{route('sessions.destroy', ['session'=>'xx'])}}" method="post">
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
<script src="{{asset('js/sessions/create.js')}}"></script>
<script>
var table = null;

$(document).ready(function() {

    table = $('#session_table').DataTable({
        "ajax": "{{route('resources.sessions.index')}}",
        "columns": [{
                "data": "name"
            },
            {
                "data": "room_no"
            },
            {
                "data": "doctor.first_name",
                "defaultContent": "N/A"
            },
            {
                "data": "nurse.first_name",
                "defaultContent": "N/A"
            },
            {
                "data": "week_day"
            },
            {
                "data": "start_at"
            },
            {
                "data": "end_at"
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

                    @can('edit session', App\ User::class)
                    editBtn = `<a type="button" class="btn btn-secondary edit-btn"
                                onclick="editSession(${data.id})">Edit</a>`;
                    @endcan

                    @can('delete session', App\ User::class)
                    deleteBtn = `<a type="button" class="btn btn-danger delete-btn"
                                onclick="deleteSession(${data.id}, '${data.name}')">Delete</a>`;
                    @endcan


                    return `${editBtn} ${deleteBtn}`;
                }
            },
        ],
    });
});

function editSession(sessionId) {
    let url = "{{route('sessions.edit', ['session' => 'xx'])}}";
    window.location.href = url.replace("xx", sessionId);
}

function deleteSession(sessionId, name) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        confirmButtonText: 'Yes, delete ' + name
    }).then((result) => {
        if (result.value) {
            deleteRequest(sessionId, name);
        }
    })
}

function deleteRequest(sessionId, name) {
    let form = $("#delete_session_form");

    $.ajax({
        type: "DELETE",
        url: form.attr("action").replace("xx", sessionId),
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

.pl-100 {
    padding-left: 100px !important;
}
</style>
@endpush