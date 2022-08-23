@extends('layouts.app')

@section('title', 'Edit Stock')

@section('content')
<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Stock</div>
                <div class="card-body">
                    <form action="{{route('stocks.update', $productStock)}}" method="post" id="stock_form" >
                        @csrf
                        @method('PUT')
                        <div class="form-group row">
                            <label for="product_id" class="col-md-4 col-form-label text-md-right">Product</label>
                            <div class="col-md-6">
                            <div class="row">
                                <select class="form-control" id="product_id" name="product_id">
                                    @foreach($products as $product)
                                    <option value="{{$product->id}}" @if($product->id == $productStock->product_id) selected @endif>{{$product->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Batch No</label>

                            <div class="col-md-6">
                            <div class="row">
                            <input id="batch_no" maxlength="20" type="text" class="form-control" name="batch_no" value="{{$productStock->batch_no}}" required>
                            </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Sell Price</label>
                            <div class="col-md-6">
                            <div class="row">
                            <input id="sell_price" type="number" class="form-control" name="sell_price" value="{{$productStock->sell_price}}" >
                            </div>
                            </div>
                            <div class="col-sm-2">
                                <input id="uom" type="text" class="form-control readonly text-right" name="uom"
                                    tabindex="-1" value="" readonly>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="button" class="btn btn-secondary" onclick="window.history.back()">Close</button>
                                <button type="submit" class="btn btn-primary" id="product_save_btn">
                                    Update Stock
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
<script src="https://unpkg.com/imask"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script src="{{asset('js/stock/edit.js')}}"></script>
<script>

var start_no;
var sto = null;

$(document).ready(function() {
    sto = @json($productstocks);
    start_no = $('#batch_no').val();
    change_uom();
});


// function validateForm() {
  
//     if($("#batch_no_exists").is(':visible')){
//                 document.getElementById("product_save_btn").disabled = true;
//                 console.log("Visible");
//                 return false;
//             } else{
//                 document.getElementById("product_save_btn").disabled = false;
//                 console.log("Not Visible");
//                 return true;
//             }
 
// }

function change_uom(){
    var app = @json($products);
    var appStock = @json($productStock);
    console.log(appStock)
    // grab the Array item which matchs the id "2"
    
    var item = app.find(item => item.id == appStock.product_id);


    var mesurement;
    if (item.uom == 'U') {
        mesurement = "Per Unit";
    } else if (item.uom == 'B') {
        mesurement = "Per Box";
    } else if (item.uom == 'C') {
        mesurement = "Per Card";
    } else if (item.uom == 'K') {
        mesurement = "Per Kg";
    }else if (item.uom  == "D") {
        mesurement = "Per Bottle";
    }

    $('#uom').attr('value', mesurement);

}

// $('#sell_price').change(function() {

// console.log($('#sell_price').val());
// if($('#sell_price').val() != ''){
//     $("#sell_price_req").hide();
//     if($('#sell_price').val() == 0 ){
//         $("#sell_price_min").show();
//     }else{
//         $("#sell_price_min").hide();
//     }
// }else{
//     $("#sell_price_min").hide();
//     $("#sell_price_req").show();
    
// }
// })

// $('#batch_no').change(function() {

// var app = @json($productstocks);
// stock_item = false;

// for(var i=0; i<app.length; i++){
//     if(app[i].batch_no === $('#batch_no').val()){
//         if(app[i].batch_no !== start_no){
//             stock_item = true;
//         }        
//     }
// }
// if(stock_item){
//     $("#batch_no_exists").show();
// }else{
//     $("#batch_no_exists").hide();
// }
// console.log(stock_item);
// })

$('#product_id').change(function() {
        var app = @json($products);
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
        }else if (item.uom == "D") {
            mesurement = "Per Bottle";
        }

        $('#uom').attr('value', mesurement);

    });
</script>



@endpush