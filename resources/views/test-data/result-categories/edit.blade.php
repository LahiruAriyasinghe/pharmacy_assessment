@extends('layouts.app')

@section('title', 'Edit Result Categories')

@section('content')
<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Result Categories</div>

                <div class="card-body">
                    <form action="{{route('test-data.result-categories.update', $resultCategory)}}" method="post"
                        id="result_categories_form">
                        @csrf
                        @method('PUT')
                        <div class="form-group row">
                            <label for="category" class="col-md-4 col-form-label text-md-right">Result Category</label>

                            <div class="col-md-6">
                                <input id="category" type="text" class="form-control" name="name"
                                    value="{{$resultCategory->result_category}}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="types" class="col-md-4 col-form-label text-md-right">Result Types (Separate by
                                comma)</label>

                            <div class="col-md-6">
                                <input id="types" type="text" class="form-control" name="types"
                                    value="{{$resultCategory->result_category_types}}" required>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="button" class="btn btn-secondary"
                                    onclick="window.history.back()">Close</button>
                                <button type="submit" class="btn btn-primary" id="result_categories_save_btn">
                                    Update Result Category
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
<script src="{{asset('js/test-data/result-categories/edit.js')}}"></script>
@endpush