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
    <div class="form-inline">
            <div class="form-group mx-sm-2 mb-2">
                <h4 class="mr-2">Total(Rs.)</h4>
                <input type="hidden" id="product_total" name="total">
            </div>
        
            <div class="form-group mb-2">
                <h1 id="product_total_val">0.00</h1>
            </div>  
    </div>
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
<script>
var total = 0;
var quotation = @json($quotation);
var transactions = [];
var invoice = [];
var price = [];
var quantities = [];
var product_name = [];

function accept(i){
    var $ = jQuery;
    console.log($('#quotation_id').val());
    jQuery.ajax({
        url: "{{ url('/accept-quotation') }}",
        method: 'post',
        data: {
            accept: i,
            id: $('#quotation_id').val()
        },
        success: function(data){
            window.open('/home');
        }
        
    });

}

$(document).ready(function($) {

    $.ajaxSetup({
    headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    // $(".owl-carousel").owlCarousel();
    $('#product_total_val').html(quotation[0].total+' /=');
    $('#product_total').val(quotation[0].total);

    var tableItems = JSON.parse(quotation[0].data)
    $.noConflict();
    window.dataTable = $('#productTable').DataTable({
        "aaSorting" : []
    });
    var $myTable = $('#productTable');
    var t = $myTable.DataTable();
    for(let i=0;i<tableItems.length;i++){
        t.row.add([JSON.parse(tableItems[i])[0].name, JSON.parse(tableItems[i])[0].quantity, JSON.parse(tableItems[i])[0].price, JSON.parse(tableItems[i])[0].price * JSON.parse(tableItems[i])[0].quantity]).draw(false);
    }
  
});


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