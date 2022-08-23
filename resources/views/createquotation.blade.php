@extends('layouts.app')

@section('title', 'Manage Other Services')

@section('content')
<div class="container">
    <div class="page-title-btn">
        <div class="page-title-with-button"><span><img class="page-title-icon"
                    src="{{ asset('img/pharmacy.svg') }}"></span>Ayubo Pharmacy</div>
        @if (Auth::user()->is_admin != 1 && $quotation[0]->user_approved == 0)
        <div class="form-group mx-sm-2 mb-2">
            <button type="button" class="btn btn-primary" onclick="accept(1)" id="accept_btn">Accept</button>
            <button type="button" class="btn btn-danger" onclick="accept(2)" id="reject_btn">Reject</button>
        </div>
        @endif
    </div>
    <hr>
    <input type="hidden" id="quotation_id" name="quotation_id" value="{{ request()->id }}">
    <form action="{{route('store_quotation')}}" method="POST" id="product_invoice_form">
                        @csrf
        <div class="form-inline">
            <div class="form-group mx-sm-3 mb-2">
                <select class="form-control" id="product" name="product[]" style="width: 100%">
                    <option value="">Select Product</option>
                    @foreach ($products as $product)
                    <option value="{{$product->id}}">{{$product->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group mx-sm-3 mb-2 mr-2">
                <label for="exampleFormControlInput1" class="mr-2">Quantity</label>
                <input type="number" class="form-control" id="quantity">
            </div>
            <div class="form-group mx-sm-3 mb-2">
                <input id="price" type="text" class="form-control readonly text-right" name="price"
                    tabindex="-1" value="" readonly>
            </div>
            <div class="form-group mx-sm-3 mb-2">
            <button type="button" id="add_item" class="btn btn-info">Add Item</button>
            <div class="row">
                <small id="add_product_error" class="text-danger" class="col-md-4"
                    style="display: none">You should add at least a one product.</small>
            </div>
            </div>
        </div>
    <div class="form-inline">
            <div class="form-group mx-sm-2 mb-2">
                <h4 class="mr-2">Total</h4>
                <input type="hidden" id="product_total" name="product_total">
            </div>
            <div class="form-group mb-2">
                <h1 id="product_total_val">0.00</h1>
            </div>
            <div class="form-group mx-sm-2 mb-2">
            <button type="submit" class="btn btn-primary mr-2" id="product_paid_btn">Send Quotaion</button>
            <button type="button" id="cancel_btn" class="btn btn-secondary mr-3">Cancel</button>
            </div>
      

        <div class="form-group row d-flex justify-content-end">
            <input type="hidden" id="prescription_id" name="prescription_id" value="{{ request()->id }}">
            <input type="hidden" id="name" name="name[]">
        </div>
    </div>
    </form>
</div>

   

<div class="container">
    <div class="row">
        <div class="col-12">
        <table class="table table-bordered yajra-datatable" id="productTable" >
            <thead>
                <tr>
                    <th>Item description</th>
                    <th>Quantity</th>
                    <th>Unit Price (LKR)</th>
                    <th>Amount (LKR)</th>
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
<script src="{{asset('js/otherServices/create.js')}}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.green.min.css"/>

<script>
var total = 0;
var products = @json($products);
var transactions = [];
var invoice = [];
var price = [];
var quantities = [];
var product_name = [];

var labInvoiceFormValidator = jQuery("#product_invoice_form").validate({
        ignore: "#quantity",
        // debug: true,
        submitHandler: function submitHandler() {
            // calculateTotal();
            store();
        }, 
        rules: {
            'name[]': {
            required: true
            }
        },
        messages: {
            'name[]': {
            required: "You should add at least a one product."
            }
        },
        errorPlacement: function errorPlacement(error, element) {
            showError(error.text());
            
        }
    }); 

    jQuery(document).ready(function ($) {
 
 $.noConflict();
 window.dataTable = $('#productTable').DataTable({
     "aaSorting" : []
 });

 $.ajaxSetup({
 headers: {
         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
     }
 });

 jQuery('#product').change(function() {
     console.log("Product Changed");
     changePrice();
 }),

 jQuery('#cancel_btn').click(function(e){
    window.open('/home');
 }),

 jQuery('#add_item').click(function (e) {
    var $ = jQuery;
     // if (validateaddButton()) {
     // e.preventDefault();
     // var hospitalFee = $('#lab_hospital_fee').val();
     // $('#product').children("option:selected").each(function (element) {
     //     reportFee += parseFloat($(this).data('fee'));
     // });
     total = total + $('#price').val() * $('#quantity').val();
     final = total.toFixed(2);
     var formattedTotal = final.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
     $('#product_total_val').html(formattedTotal);
     $('#product_total').val(final);
     var myObject = new Object();
     myObject.name = $("#product option:selected").text();
     myObject.quantity = $('#quantity').val();
     myObject.price = $('#price').val() * $('#quantity').val();
     transactions.push(myObject);
     item = {};
     item['name'] = $("#product option:selected").text();
     item['price'] = $('#price').val() * $('#quantity').val();
     item['quantity'] = parseFloat($('#quantity').val());
     invoice.push(item);
     $("#add_product_error").hide();
     var $myTable = $('#productTable');
     var t = $myTable.DataTable();
     t.row.add([$("#product option:selected").text(), parseFloat($('#quantity').val()), $('#price').val(), $('#price').val() * $('#quantity').val(), "<a type=\"button\" class=\"btn btn-danger delete-btn\" id=\"delete\"\n                              >Delete</a>"]).draw(false); // window.dataTable.rows.add([


     price.push($('#price').val() * $('#quantity').val());
     quantities.push($('#quantity').val());
     product_name.push($("#product option:selected").text());
     $('#amount').val(price);
     $('#units').val(quantities);
     $('#name').val(JSON.stringify(invoice)); // $('#name').val(JSON.stringify(product_name));
 
 });
 $(".owl-carousel").owlCarousel();
});

function changePrice() {
    var $ = jQuery;
    var products = @json($products);
    jsonObj = [];
    for (var k = 0; k < products.length; k++) {
        if (products[k].id == $('#product').val()) {
            jsonObj.push(products[k]);
            $('#price').val(products[k].amount.toFixed(2));
        }
    }
}

function store() {
    var $ = jQuery;
var form = $("#product_invoice_form");
console.log(invoice);
// togglePaidButton(true);
$.ajax({
    type: "POST",
    url: form.attr("action"),
    data: form.serialize(),
    success: function success(response) {
        // togglePaidButton(false);

        if ("success" in response) {
            // clear form
            // show message
            Swal.fire({
            text: "Transaction Completed",
            icon: 'success',
            showCancelButton: true,
            reverseButtons: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Print invoice',
            cancelButtonText: 'Close'
            }).then(function (result) {
            if (result.value) {
                window.open(response.data.invoice_pdf_url);
            }
            cancelInvoice();
            });
            return;
        } // something went wrong
        // show error msg
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Something went wrong!'
        });
        return;
    },
    error: function error(request, status, _error) {
    console.error("error :>> ", request.responseText);
    togglePaidButton(false); // something went wrong

    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Something went wrong!'
    });
    return;
    }
});
}

function changeTasks(tasksArr) {
    // console.log(productsArr);
    tasks = tasksArr;
    $('#task_id').empty();
    $.each(tasks, function(i, p) {
        $('#task_id').append($('<option></option>').val(p.id).html(p.name));
    });
}

function showError(e){
    console.log(e);
    $("#add_product_error").show();
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Something went wrong!'
    });
}

function validateaddButton() {
    var quantity = $("#quantity").val();
    var product = $("#product").val();
    var product_stock = $("#product_stock").val();
    var valid = true;

    if(quantity == ''){
        $("#quantity_zero").show();
        $("#quantity_min").hide();
        valid = false;
    }else{
        $("#quantity_zero").hide();
        if (quantity <= 0){
        $("#quantity_min").show();
        valid = false;
        }
    }

    if (product == '') {
        $("#select_product").show();
        valid =  false;
    } else {
        $("#select_product").hide();
    }

    console.log(product_stock);

    if (product_stock == null) {
        $("#select_stock").show();
        valid =  false;
    } else {
        $("#select_stock").hide();
    }

    return valid;
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