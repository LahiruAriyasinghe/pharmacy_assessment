@extends('layouts.app')

@section('title', 'Manage Lab Report Results')

@section('content')
<div class="container">
    <div class="page-title-btn">
        <div class="page-title-with-button"><span><img class="page-title-icon"
                    src="{{ asset('img/result.svg') }}"></span>Lab Report Results</div>
    </div>
    <hr>
</div>

<div class="container">
    <div class="row">
        <div class="col-12">
            <table id="lab_report_results_table" class="table table-bordered hover" style="width:100%">
                <thead>
                    <tr class="table-title">
                        <th>Report Name</th>
                        <th>Sample Id</th>
                        <th>Invoice Id</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
<script src="https://unpkg.com/imask"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script>
    var table = null;
    var SELECTED_STATUS = "incomplete";
    var indexUrl = "{{route('resources.lab-reports.results.index', ['status' => 'xx'])}}";

$(document).ready(function() {

    table = $('#lab_report_results_table').DataTable({
        "ajax": indexUrl.replace("xx", SELECTED_STATUS),
        "order": [
            [1, "desc"]
        ],
        "columns": [{
                "data": "name"
            },
            {
                "data": "sample_no"
            },
            {
                "data": "invoice_id"
            },
            {
                "data": "created_at"
            },
            {
                "data": null
            },
        ],
        "columnDefs": [{
                "targets": 2,
                "orderable": false,
            },
            {
                "targets": -1,
                "data": null,
                "render": function(data, type, row, meta) {
                    let editBtn = '';
                    let printBtn = '';

                    @can('edit lab report', App\ User::class)
                    
                    if(SELECTED_STATUS === 'incomplete'){
                        editBtn = `<a type="button" class="btn btn-secondary edit-btn"
                                    onclick="editLabReportResult(${data.id})">Edit</a>`;
                    }
                    @endcan
                   
                    
                    @can('print patient lab report', App\ User::class)
                    
                    if(SELECTED_STATUS === 'completed'){
                        printBtn = `<button type="button" id="printBtn${data.id}" class="btn btn-primary"
                                    onclick="printLabReportResult(${data.id})">Print</button>
                                    <button class="btn btn-primary" type="button" id="loadingBtn${data.id}" disabled style="display:none;">
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                    Loading...
                                    </button>`;
                    }
                    
                    @endcan

                    return `${editBtn} ${printBtn}`;
                }
            },
        ],
    });

    $('<div class="pull-right mr-3">' +
            '<select class="form-control" id="result_status">' +
                '<option value="incomplete">Incomplete</option>' +
                '<option value="completed">Completed</option>' +
            '</select>' +
        '</div>').appendTo("#lab_report_results_table_wrapper .dataTables_filter");

    $(".dataTables_filter label").addClass("pull-right");
});

$(document).on('change',"#result_status", function(){
    SELECTED_STATUS = $("#result_status").val();
    table.ajax.url(indexUrl.replace("xx", SELECTED_STATUS)).load();
});  

function editLabReportResult(reportId) {
    let url = "{{route('lab-reports.results.edit', ['result' => 'xx'])}}";
    window.location.href = url.replace("xx", reportId);
}

function printLabReportResult(reportId) {
    let url = "{{route('lab-reports.results.print', ['result' => 'xx'])}}";

    $(`#printBtn${reportId}`).hide();
    $(`#loadingBtn${reportId}`).show();

    $.ajax({
        type: "GET",
        url: url.replace("xx", reportId),
        success: function(response) {
            console.log(response);
            $(`#loadingBtn${reportId}`).hide();
            $(`#printBtn${reportId}`).show();

            if ("success" in response) {
                window.open(response.data.report_url);
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
            $(`#loadingBtn${reportId}`).hide();
            $(`#printBtn${reportId}`).show();

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

    select {
        background-image: linear-gradient(45deg, transparent 50%, gray 50%),
            linear-gradient(135deg, gray 50%, transparent 50%);
        width: 130px !important;
    }
</style>
@endpush