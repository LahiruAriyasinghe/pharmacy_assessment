@extends('layouts.app')

@section('title', 'Manage Pharmacy Products')

@section('content')
<div class="container">
    <div class="page-title-btn">
        <div class="page-title-with-button"><span><img class="page-title-icon"
                    src="{{ asset('img/pharmacy.svg') }}"></span>Pharmacy Products</div>

        <div>
            @can('create product', App\User::class)
            <Button type="button" class="btn btn-primary" data-toggle="modal" data-target="#new_stock_model">Add New
                Stock</Button>
            @endcan
            @can('create product', App\User::class)
            <Button type="button" class="btn btn-primary" data-toggle="modal" data-target="#new_product_model">Add New
                Product</Button>
            @endcan
        </div>
    </div>
    <hr>
</div>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link {{ empty($tabName) || $tabName == 'stock' ? 'active' : '' }}" id="pills-stock-tab" data-toggle="pill" href="#stock_tab" role="tab"
                        aria-controls="pills-lab" aria-selected="false">Stock</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ empty($tabName) || $tabName == 'product' ? 'active' : '' }}" id="pills-product-tab" data-toggle="pill" href="#product_tab" role="tab"
                        aria-controls="pills-opd" aria-selected="true">Product</a>
                </li>
            </ul>
            <hr><br>

            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade {{ empty($tabName) || $tabName == 'product' ? 'show active' : '' }}" id="product_tab" role="tabpanel" aria-labelledby="pills-product-tab">    
                    <table id="product_table" class="table table-bordered hover" style="width:100%">
                        <thead>
                            <tr class="table-title">
                                <th>Product Name</th>
                                <th>UOM</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            <div class="tab-pane fade {{ empty($tabName) || $tabName == 'stock' ? 'show active' : '' }}" id="stock_tab" role="tabpanel" aria-labelledby="pills-stock-tab">
                    <table id="stock_table" class="table table-bordered hover" style="width:100%">
                        <thead>
                            <tr class="table-title">
                                <th>Stock Number</th>
                                <th>Sell Price</th>
                                <th>Product Name</th>
                                <th>UOM</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                    </table>
            </div>
            </div>
    </div>
</div>       
</div>

<!-- Modal Add New Stock-->
<div class="modal fade" id="new_stock_model" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
    aria-labelledby="new_stock_model" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Stock</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="">
                    <form action="{{route('stocks.store')}}" method="post" id="stock_form">
                        @csrf
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Product</label>
                            <div class="col-md-6">
                            <div class="row">
                                <select class="form-control" id="product_id" name="product_id">
                                    @foreach($products as $product)
                                    <option value="{{$product->id}}">{{$product->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            </div>
                            <div class="col-md-4"></div>
                            <small id="product_help" class="text" class="col-md-6">
                                If your produt name not available here? You want to first create the product.
                            </small>
                        </div>


                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Batch No</label>

                            <div class="col-md-6">
                            <div class="form-group row">
                                <input id="batch_no" maxlength="20"  type="text" class="form-control" name="batch_no" autocomplete="off">
                            </div>
                            </div>
                            <div class="col-md-4"></div>
                        </div>

                        <div class="form-group row">
                            <label for="sell_price" class="col-md-4 col-form-label text-md-right">Sell Price(
                                Rs/=)</label>
                            <div class="col-md-6">
                            <div class="row">
                                <input id="sell_price" type="number" placeholder="Per Unit" class="form-control"
                                    name="sell_price">
                            </div>
                            </div>
                            <div class="col-md-4"></div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="stock_cancel_btn" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" id="new_stock_save_btn" class="btn btn-primary">Save and Add</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Add New Stock-->

<!-- Modal Add New Product-->
<div class="modal fade" id="new_product_model" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
    aria-labelledby="new_product_model" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="">
                    <form action="{{route('products.store')}}" method="post" id="product_form">
                        @csrf
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Product Type</label>
                            <div class="col-md-6">
                                <select class="form-control" id="product_type_id" name="product_type_id">
                                    @foreach($product_types as $product_type)
                                    <option value="{{$product_type->id}}">{{$product_type->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="uom" class="col-md-4 col-form-label text-md-right">Unit of Measurement</label>
                            <div class="col-md-6">
                                <select class="form-control" id="uom" name="uom">
                                    <option value="U">Unit</option>
                                    <option value="C">Card</option>
                                    <option value="K">Kg</option>
                                    <option value="B">Box</option>
                                    <option value="D">Bottle</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="product_cancel_btn" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" id="new_product_save_btn" class="btn btn-primary">Save and Add</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Add New Product-->

<!-- Modal Edit speciality-->
<div class="modal fade" id="editUser" tabindex="-1" role="dialog" aria-labelledby="editUser" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUser">Edit product</h5>
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

<form id="delete_product_form" action="{{route('products.destroy', ['product'=>'xx'])}}" method="post">
    @csrf
    @method('DELETE')
</form>

<form id="delete_stock_form" action="{{route('stocks.destroy', ['stock'=>'xx'])}}" method="post">
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

<script src="{{asset('js/products/create.js')}}"></script>
<script src="{{asset('js/stock/create.js')}}"></script>
<script>
var table = null;
var prod;
var sto = null;
var ROUTES = '{{ route('resources.stock-exists') }}';


$(document).ready(function() {
    sto = @json($productstocks);
    table_stock = $('#stock_table').DataTable({

        "ajax": {
            "url": "{{route('resources.stock.index')}}",
            "dataSrc": ""
        },
        "columns": [{
                "data": "batch_no"
            },
            {
                "data": "sell_price"
            },
            {
                "data": "product.name"

            },
            {
                "data": "product.uom",
                "render": function(data, type, row) {

                    if (row.product.uom === "U") {
                        return 'Unit';
                    } else if (row.product.uom === "B") {
                        return 'Box';
                    } else if (row.product.uom === "K") {
                        return 'Kg'
                    } else if (row.product.uom === "C") {
                        return 'Card'
                    }else if (row.product.uom === 'D') {
                        return 'Bottle'
                    }
                }

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

                    @can('edit product', App\ User::class)
                    editBtn = `<a type="button" class="btn btn-secondary edit-btn"
                                onclick="editstock(${data.id})">Edit</a>`;
                    @endcan

                    @can('delete product', App\ User::class)
                    deleteBtn = `<a type="button" class="btn btn-danger delete-btn"
                                onclick="deletestock(${data.id}, '${data.batch_no}')">Delete</a>`;
                    @endcan

                    return `${editBtn} ${deleteBtn}`;
                }
            },
        ],

    });

    table = $('#product_table').DataTable({

        "ajax": {
            "url": "{{route('resources.product.index')}}",
            "dataSrc": ""
        },
        "columns": [{
                "data": "name"
            },
            {
                "data": "uom",
                "render": function(data, type, row) {

                    if (row.uom === "U") {
                        return 'Unit';
                    } else if (row.uom === "B") {
                        return 'Box';
                    } else if (row.uom === "K") {
                        return 'Kg'
                    } else if (row.uom === "C") {
                        return 'Card'
                    }else if (row.uom === 'D') {
                        return 'Bottle'
                    }
                }

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

                    @can('edit product', App\ User::class)
                    editBtn = `<a type="button" class="btn btn-secondary edit-btn"
                                onclick="editproduct(${data.id})">Edit</a>`;
                    @endcan

                    @can('delete product', App\ User::class)
                    deleteBtn = `<a type="button" class="btn btn-danger delete-btn"
                                onclick="deleteproduct(${data.id}, '${data.name}')">Delete</a>`;
                    @endcan

                    return `${editBtn} ${deleteBtn}`;
                }
            },
        ],

    });


    $('#product_id').change(function() {
        
        if(prod === null){
            var app = @json($products);
        }else{
            var app = prod;
        }
       
        // grab the Array item which matchs the id "2"
        
        var item = app.find(item => item.id == $(this).val());


        var mesurement;
        if (item.uom == 'U') {
            mesurement = "Per Unit";
        } else if (item.uom == 'B') {
            mesurement = "Per Box";
        } else if (item.uom == 'C') {
            mesurement = "Per Card";
        } else if (item.uom == 'K') {
            mesurement = "Per Kg";
        }else if (item.uom == 'D') {
            mesurement = "Per Bottle";
        }

        $('#sell_price').attr('placeholder', mesurement);

    });
});

function editstock(productId) {
  
    var productStocks = @json($productstocks);
    let url = "{{route('stocks.edit', ['stock' => 'xx'])}}";
    window.location.href = url.replace("xx", productId);
}

function deletestock(productId, name) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        confirmButtonText: 'Yes, delete the stock'
    }).then((result) => {
        if (result.value) {
            stockdeleteRequest(productId, name);
        }
    })
}

function editproduct(productId) {
    console.log(productId);
    let url = "{{route('products.edit', ['product' => 'xx'])}}";
    window.location.href = url.replace("xx", productId);
}

function deleteproduct(productId, name) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        confirmButtonText: 'Yes, delete ' + name
    }).then((result) => {
        if (result.value) {
            deleteRequest(productId, name);
        }
    })
}

function stockdeleteRequest(productId, name) {
    let form = $("#delete_stock_form");

    $.ajax({
        type: "DELETE",
        url: form.attr("action").replace("xx", productId),
        data: form.serialize(),
        success: function(response) {
            console.log(response);

            if ("success" in response) {
                Swal.fire({
                    title: 'Deleted!',
                    text: 'Stock has been deleted.',
                    icon: 'success',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                }).then((result) => {
                    if (result.value) {
                        table_stock.ajax.reload();
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

function changeProducts(productsArr) {
  // console.log(productsArr);
  prod = productsArr;
  $('#product_id').empty();
  $.each(prod, function(i, p) {
      $('#product_id').append($('<option></option>').val(p.id).html(p.name));
  });
}

function deleteRequest(productId, name) {
    let form = $("#delete_product_form");
    $.ajax({
        type: "DELETE",
        url: form.attr("action").replace("xx", productId),
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
                        table_stock.ajax.reload();
                        changeProducts(response.result);
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