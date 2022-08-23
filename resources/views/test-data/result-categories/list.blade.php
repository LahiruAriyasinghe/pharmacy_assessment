@extends('layouts.app')

@section('title', 'Manage Result Categories')

@section('content')
<div class="container">
    <div class="page-title-btn">
        <div class="page-title-with-button"><span><img class="page-title-icon"
                    src="{{ asset('img/result-category.svg') }}"></span>Result Categories</div>
        @can('create result category', App\User::class)
        <Button type="button" class="btn btn-primary" data-toggle="modal" data-target="#new_result_category_model">Add
            New
            Result Category</Button>
        @endcan
    </div>
    <hr>
</div>

<div class="container">

    <div class="row">
        <div class="col-12">
            <table id="result_categories_table" class="table table-bordered hover" style="width:100%">
                <thead>
                    <tr class="table-title">
                        <th>Result Category</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>

            </table>
        </div>
    </div>
</div>

<!-- Modal Add New Result Category-->
<div class="modal fade" id="new_result_category_model" data-backdrop="static" data-keyboard="false" tabindex="-1"
    role="dialog" aria-labelledby="new_result_category_model" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Result Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="">
                    <form action="{{route('test-data.result-categories.store')}}" method="post"
                        id="result_categories_form">
                        @csrf
                        <div class="form-group row">
                            <label for="category" class="col-md-4 col-form-label text-md-right">Result Category</label>
                            <div class="col-md-6">
                                <input id="category" type="text" class="form-control" name="name" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="types" class="col-md-4 col-form-label text-md-right">Result Types (Separate by
                                comma)</label>
                            <div class="col-md-6">
                                <input id="types" type="text" class="form-control" name="types" required>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" id="new_result_category_save_btn" class="btn btn-primary">Save and Add</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Add New Result Category-->

<form id="delete_result_category_form"
    action="{{route('test-data.result-categories.destroy', ['result_category'=>'xx'])}}" method="post">
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
<script src="{{asset('js/test-data/result-categories/create.js')}}"></script>
<script>
var table = null;

$(document).ready(function() {

    table = $('#result_categories_table').DataTable({
        "ajax": "{{route('resources.test-data.result-categories.index')}}",
        "columns": [{
                "data": "result_category"
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

                    @can('edit result category', App\ User::class)
                    editBtn = `<a type="button" class="btn btn-secondary edit-btn"
                                onclick="editResultCategory(${data.id})">Edit</a>`;
                    @endcan

                    @can('delete result category', App\ User::class)
                    deleteBtn = `<a type="button" class="btn btn-danger delete-btn"
                                onclick="deleteResultCategory(${data.id}, '${data.name}')">Delete</a>`;
                    @endcan

                    return `${editBtn} ${deleteBtn}`;
                }
            },
        ],
    });
});

function editResultCategory(resultCategoryId) {
    let url = "{{route('test-data.result-categories.edit', ['result_category' => 'xx'])}}";
    window.location.href = url.replace("xx", resultCategoryId);
}

function deleteResultCategory(resultCategoryId, resultCategory) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        confirmButtonText: 'Yes, delete ' + resultCategory
    }).then((result) => {
        if (result.value) {
            deleteRequest(resultCategoryId, resultCategory);
        }
    })
}

function deleteRequest(resultCategoryId, resultCategory) {
    let form = $("#delete_result_category_form");

    $.ajax({
        type: "DELETE",
        url: form.attr("action").replace("xx", resultCategoryId),
        data: form.serialize(),
        success: function(response) {
            console.log(response);

            if ("success" in response) {
                Swal.fire({
                    title: 'Deleted!',
                    text: resultCategory + ' has been deleted.',
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