@extends('layouts.app')

@section('title', 'Edit Product')

@section('content')
<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Product</div>
                <div class="card-body">
                    <form action="{{route('products.update', $product)}}" method="post" id="product_form">
                        @csrf
                        @method('PUT')
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>

                            <div class="col-md-6">
                            <input id="name" type="text" class="form-control" name="name" value="{{$product->name}}" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Producy Type</label>
                            <div class="col-md-6">
                                <select class="form-control" id="product_type_id" name="product_type_id">
                                    @foreach($product_types as $product_type)
                                    <option value="{{$product_type->id}}" @if($product_type->id == $product->product_type_id) selected @endif>{{$product_type->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="uom" class="col-md-4 col-form-label text-md-right">Unit of Measurement</label>
                            <div class="col-md-6">
                            <select class="form-control" id="uom" name="uom">
                                    <option value="U"  {{ $product->uom == "U" ? 'selected' : '' }} >Unit</option>
                                    <option value="C" {{ $product->uom == "C" ? 'selected' : '' }} >Card</option>
                                    <option value="K" {{ $product->uom == "K" ? 'selected' : '' }} >Kg</option>
                                    <option value="B" {{ $product->uom == "B" ? 'selected' : '' }}>Box</option>
                                    <option value="D" {{ $product->uom == "D" ? 'selected' : '' }}>Bottle</option>
                            </select> 
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="button" class="btn btn-secondary" onclick="window.history.back()">Close</button>
                                <button type="submit" class="btn btn-primary" id="product_save_btn">
                                    Update Product
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
<script src="{{asset('js/products/edit.js')}}"></script>
@endpush