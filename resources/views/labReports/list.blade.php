@extends('layouts.app')

@section('title', 'Manage Lab Reports')

@section('content')
<div class="container">
    <div class="page-title-btn">
        <div class="page-title-with-button"><span><img class="page-title-icon"
                    src="{{ asset('img/result.svg') }}"></span>Lab Reports</div>
        @can('create lab report', App\User::class)
        <Button type="button" class="btn btn-primary" data-toggle="modal" data-target="#new_report_model">Add New
            Report</Button>
        @endcan
    </div>
    <hr>
</div>

<div class="container">

    <div class="row">
        <div class="col-12">
            <table id="report_table" class="table table-bordered hover" style="width:100%">
                <thead>
                    <tr class="table-title">
                        <th>Name</th>
                        <th>Acronym</th>
                        <th>Fee</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>

            </table>
        </div>
    </div>
</div>

<!-- Modal Add New speciality-->
<div class="modal fade" id="new_report_model" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
    aria-labelledby="new_report_model" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Report</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="">
                    <form action="{{route('lab-reports.store')}}" method="post" id="report_form">
                        @csrf
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="acronym" class="col-md-4 col-form-label text-md-right">Acronym</label>

                            <div class="col-md-6">
                                <input id="acronym" type="text" class="form-control" name="acronym" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="fee" class="col-md-4 col-form-label text-md-right">Service Fee</label>

                            <div class="col-md-6">
                                <input id="fee" type="text" class="form-control" name="fee">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="lab_report_categories_id" class="col-md-4 col-form-label text-md-right">Report
                                Category</label>
                            <div class="col-md-6">
                                <select class="form-control" id="lab_report_categories_id"
                                    name="lab_report_categories_id" style="width: 100%">
                                    <option value="" disabled selected>Select Report Category</option>
                                    @foreach ($labReportCategories as $cateogories)
                                    <option value="{{$cateogories->id}}">{{$cateogories->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="reference_report" class="col-md-4 col-form-label text-md-right">
                                Reference Report
                            </label>
                            <div class="col-md-6">
                                <select class="form-control" id="reference_report" name="reference_report"
                                    style="width: 100%">
                                    <option value="" selected>Not a Reference Report</option>
                                    @foreach ($labReports as $labReport)
                                    <option value="{{$labReport->id}}">{{$labReport->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="test_datas" class="col-md-4 col-form-label text-md-right">Test Data</label>
                            <div class="col-md-6">
                                <select class="form-control" id="test_datas" name="test_datas[]" multiple="multiple"
                                    style="width: 100%">
                                    <option value="" disabled>Select Test Data</option>
                                    @foreach ($testDatas as $testData)
                                    <option value="{{$testData->id}}">{{$testData->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" id="new_report_save_btn" class="btn btn-primary">Save and Add</button>
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
                <h5 class="modal-title" id="editUser">Edit Report</h5>
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

<form id="delete_report_form" action="{{route('lab-reports.destroy', ['lab_report'=>'xx'])}}" method="post">
    @csrf
    @method('DELETE')
</form>

@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script src="https://unpkg.com/imask"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script src="{{asset('js/labReports/create.js')}}"></script>
<script>
    var table = null;

$(document).ready(function() {

    table = $('#report_table').DataTable({
        "ajax": "{{route('resources.lab-reports.index')}}",
        "columns": [{
                "data": "name"
            },
            {
                "data": "acronym",
                "defaultContent": "N/A"
            },
            {
                "data": "fee"
            },
            {
                "data": "created_at"
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

                    @can('edit lab report', App\ User::class)
                    editBtn = `<a type="button" class="btn btn-secondary edit-btn"
                                onclick="editReport(${data.id})">Edit</a>`;
                    @endcan

                    @can('delete lab report', App\ User::class)
                    deleteBtn = `<a type="button" class="btn btn-danger delete-btn"
                                onclick="deleteReport(${data.id}, '${data.name}')">Delete</a>`;
                    @endcan

                    return `${editBtn} ${deleteBtn}`;
                }
            },
        ],
    });
    $('#test_datas').select2({
        maximumSelectionLength: 20,
        closeOnSelect: false
    });

    $("#test_datas").on("select2:select", function (evt) {
        var element = evt.params.data.element;
        var $element = $(element);
        
        $element.detach();
        $(this).append($element);
        $(this).trigger("change");
    });
});

function editReport(reportId) {
    let url = "{{route('lab-reports.edit', ['lab_report' => 'xx'])}}";
    window.location.href = url.replace("xx", reportId);
}

function deleteReport(reportId, name) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        confirmButtonText: 'Yes, delete ' + name
    }).then((result) => {
        if (result.value) {
            deleteRequest(reportId, name);
        }
    })
}

function deleteRequest(reportId, name) {
    let form = $("#delete_report_form");

    $.ajax({
        type: "DELETE",
        url: form.attr("action").replace("xx", reportId),
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
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
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