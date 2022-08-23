@extends('layouts.app')

@section('title', 'Manage Categories')

@section('content')
<div class="container">
    <div class="page-title-btn">
        <div class="page-title-with-button"><span><img class="page-title-icon"
                    src="{{ asset('img/reoprt-category.svg') }}"></span>Categories</div>
        @can('create lab report', App\User::class)
        <Button type="button" class="btn btn-primary" data-toggle="modal" data-target="#new_category_model">Add New
            Category</Button>
        @endcan
    </div>
    <hr>
</div>

<div class="container">

    <div class="row">
        <div class="col-12">
            <table id="category_table" class="table table-bordered hover" style="width:100%">
                <thead>
                    <tr class="table-title">
                        <th>Category</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>

            </table>
        </div>
    </div>
</div>

<!-- Modal Add New Category-->
<div class="modal fade" id="new_category_model" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
    aria-labelledby="new_category_model" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="">
                    <form action="{{route('lab-reports.categories.store')}}" method="post" id="categories_form">
                        @csrf
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Category</label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" required>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" id="new_category_save_btn" class="btn btn-primary">Save and Add</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Add New Category-->

<form id="delete_category_form" action="{{route('lab-reports.categories.destroy', ['category'=>'xx'])}}" method="post">
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
<script src="{{asset('js/labReports/categories/create.js')}}"></script>
<script>
var table = null;

$(document).ready(function() {

    table = $('#category_table').DataTable({
        "ajax": "{{route('resources.lab-reports.categories.index')}}",
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
                                onclick="editCategory(${data.id})">Edit</a>`;
                    @endcan

                    @can('delete lab report', App\ User::class)
                    deleteBtn = `<a type="button" class="btn btn-danger delete-btn"
                                onclick="deleteCategory(${data.id}, '${data.result_category}')">Delete</a>`;
                    @endcan

                    return `${editBtn} ${deleteBtn}`;
                }
            },
        ],
    });
});

function editCategory(categoryId) {
    let url = "{{route('lab-reports.categories.edit', ['category' => 'xx'])}}";
    window.location.href = url.replace("xx", categoryId);
}

function deleteCategory(categoryId, category) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        confirmButtonText: 'Yes, delete ' + category
    }).then((result) => {
        if (result.value) {
            deleteRequest(categoryId, category);
        }
    })
}

function deleteRequest(categoryId, category) {
    let form = $("#delete_category_form");

    $.ajax({
        type: "DELETE",
        url: form.attr("action").replace("xx", categoryId),
        data: form.serialize(),
        success: function(response) {
            console.log(response);

            if ("success" in response) {
                Swal.fire({
                    title: 'Deleted!',
                    text: category + ' has been deleted.',
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