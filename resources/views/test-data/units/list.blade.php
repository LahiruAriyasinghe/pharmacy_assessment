@extends('layouts.app')

@section('title', 'Manage Units')

@section('content')
<div class="container">
    <div class="page-title-btn">
        <div class="page-title-with-button"><span><img class="page-title-icon"
                    src="{{ asset('img/test-tube.svg') }}"></span>Measuring Units</div>
        @can('create unit', App\User::class)
        <Button type="button" class="btn btn-primary" data-toggle="modal" data-target="#new_unit_model">Add New
            Unit</Button>
        @endcan
    </div>
    <hr>
</div>

<div class="container">

    <div class="row">
        <div class="col-12">
            <table id="units_table" class="table table-bordered hover" style="width:100%">
                <thead>
                    <tr class="table-title">
                        <th>Unit</th>
                        <th>Name</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>

            </table>
        </div>
    </div>
</div>

<!-- Modal Add New Unit-->
<div class="modal fade" id="new_unit_model" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
    aria-labelledby="new_unit_model" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Unit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="">
                    <form action="{{route('units.store')}}" method="post" id="units_form">
                        @csrf
                        <div class="form-group row">
                            <label for="unit" class="col-md-4 col-form-label text-md-right">Unit</label>
                            <div class="col-md-6">
                                <input id="unit" type="text" class="form-control" name="unit" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" required>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" id="new_unit_save_btn" class="btn btn-primary">Save and Add</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Add New Unit-->

<form id="delete_unit_form" action="{{route('units.destroy', ['unit'=>'xx'])}}" method="post">
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
<script src="{{asset('js/units/create.js')}}"></script>
<script>
var table = null;

$(document).ready(function() {

    table = $('#units_table').DataTable({
        "ajax": "{{route('resources.test-data.units.index')}}",
        "columns": [{
                "data": "unit"
            },
            {
                "data": "name",
                "defaultContent": "N/A"
            },
            {
                "data": "created_at"
            },
            {
                "data": null
            },
        ],
        "columnDefs": [{
                targets: [2, 3],
                orderable: false
            },
            {
                "targets": -1,
                "data": null,
                "render": function(data, type, row, meta) {
                    let editBtn = '';
                    let deleteBtn = '';

                    @can('edit unit', App\ User::class)
                    editBtn = `<a type="button" class="btn btn-secondary edit-btn"
                                onclick="editUnit(${data.id})">Edit</a>`;
                    @endcan

                    @can('delete unit', App\ User::class)
                    deleteBtn = `<a type="button" class="btn btn-danger delete-btn"
                                onclick="deleteUnit(${data.id}, '${data.unit}')">Delete</a>`;
                    @endcan

                    return `${editBtn} ${deleteBtn}`;
                }
            },
        ],
    });
});

function editUnit(unitId) {
    let url = "{{route('units.edit', ['unit' => 'xx'])}}";
    window.location.href = url.replace("xx", unitId);
}

function deleteUnit(unitId, unit) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        confirmButtonText: 'Yes, delete ' + unit
    }).then((result) => {
        if (result.value) {
            deleteRequest(unitId, unit);
        }
    })
}

function deleteRequest(unitId, unit) {
    let form = $("#delete_unit_form");

    $.ajax({
        type: "DELETE",
        url: form.attr("action").replace("xx", unitId),
        data: form.serialize(),
        success: function(response) {
            console.log(response);

            if ("success" in response) {
                Swal.fire({
                    title: 'Deleted!',
                    text: unit + ' has been deleted.',
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