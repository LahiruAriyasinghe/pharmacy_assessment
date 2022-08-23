@extends('layouts.app')

@section('title', 'Manage Test Data')

@section('content')
<div class="container">
    <div class="page-title-btn">
        <div class="page-title-with-button"><span><img class="page-title-icon"
                    src="{{ asset('img/lab-data.svg') }}"></span>Lab Test Data</div>
        @can('create test data', App\User::class)
        <a type="button" class="btn btn-primary" href="{{ route('test-datas.create') }}">Add
            New
            Test Data</a>
        @endcan
    </div>
    <hr>
</div>

<div class="container">
    <div class="row">
        <div class="col-12">
            <table id="test_data_table" class="table table-bordered hover" style="width:100%">
                <thead>
                    <tr class="table-title">
                        <th>Test Data</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<form id="delete_test_data_form" action="{{route('test-datas.destroy', ['test_data'=>'xx'])}}" method="post">
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
<script src="{{asset('js/test-data/create.js')}}"></script>
<script>
    var table = null;

$(document).ready(function() {

    table = $('#test_data_table').DataTable({
        "ajax": "{{route('resources.test-datas.index')}}",
        "columns": [{
                "data": "name"
            },
            {
                "data": "created_at"
            },
            {
                "data": null
            },
        ],
        "columnDefs": [{
                targets: [1, 2],
                orderable: false
            },
            {
                "targets": -1,
                "data": null,
                "render": function(data, type, row, meta) {
                    let editBtn = '';
                    let deleteBtn = '';

                    @can('edit test data', App\ User::class)
                    editBtn = `<a type="button" class="btn btn-secondary edit-btn"
                                onclick="editTestData(${data.id})">Edit</a>`;
                    @endcan

                    @can('delete test data', App\ User::class)
                    deleteBtn = `<a type="button" class="btn btn-danger delete-btn"
                                onclick="deleteTestData(${data.id}, '${data.name}')">Delete</a>`;
                    @endcan

                    return `${editBtn} ${deleteBtn}`;
                }
            },
        ],
    });
});

function editTestData(testDataId) {
    let url = "{{route('test-datas.edit', ['test_data' => 'xx'])}}";
    window.location.href = url.replace("xx", testDataId);
}

function deleteTestData(testDataId, testData) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        confirmButtonText: 'Yes, delete ' + testData
    }).then((result) => {
        if (result.value) {
            deleteRequest(testDataId, testData);
        }
    })
}

function deleteRequest(testDataId, testData) {
    let form = $("#delete_test_data_form");

    $.ajax({
        type: "DELETE",
        url: form.attr("action").replace("xx", testDataId),
        data: form.serialize(),
        success: function(response) {
            console.log(response);

            if ("success" in response) {
                Swal.fire({
                    title: 'Deleted!',
                    text: testData + ' has been deleted.',
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