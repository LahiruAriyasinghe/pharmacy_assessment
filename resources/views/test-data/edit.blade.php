@extends('layouts.app')

@section('title', 'Edit Test Data')

@section('content')
<div class="container">
    <div class="page-title-btn">
        <div class="page-title-with-button">
            <span>
                <img class="page-title-icon" src="{{ asset('img/lab-data.svg') }}">
            </span>Edit Test Data
        </div>
    </div>
    <hr>
</div>

<div class="container">
    <div class="row">
        <div class="col-12">
            <form action="{{route('test-datas.update', $testData)}}" method="post" id="test_data_form">
                @csrf
                @method('PUT')
                <div class="form-group row">
                    <label for="category" class="col-md-4 col-form-label text-md-right">Test Data</label>

                    <div class="col-md-6">
                        <input id="category" type="text" class="form-control" name="name" value="{{$testData->name}}"
                            required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="description" class="col-md-4 col-form-label text-md-right">Test Data
                        Description</label>
                    <div class="col-md-6">
                        <input id="description" type="text" class="form-control" name="description"
                            value="{{$testData->description}}" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="result_category" class="col-md-4 col-form-label text-md-right">Result
                        Category</label>
                    <div class="col-md-4">
                        <select class="form-control" id="result_category" name="test_data_result_category_id">
                            @foreach ($resultCategories as $resultCategory)
                            <option value="{{$resultCategory->id}}" @if ($testData->
                                test_data_result_category_id==$resultCategory->id) selected
                                @endif>{{ $resultCategory->result_category }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="unit" class="col-md-4 col-form-label text-md-right">Unit</label>
                    <div class="col-md-4">
                        <select class="form-control" id="unit" name="unit_id">
                            <option value="">No Unit
                            </option>
                            @foreach ($units as $unit)
                            <option value="{{$unit->id}}" @if ($testData->unit_id==$unit->id) selected
                                @endif>{{ $unit->unit }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="categories" class="col-md-4 col-form-label text-md-right">Category</label>
                    <div class="col-md-4">
                        <select class="form-control" id="categories" name="test_data_category_id">
                            <option value="">No Category
                            </option>
                            @foreach ($categories as $category)
                            <option value="{{$category->id}}" @if ($testData->
                                test_data_category_id==$category->id) selected @endif>{{ $category->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <hr>

                <!-- Range Table -->
                <div class="row mt-3 add-new-range-btn">
                    <div class="col-12">
                        <div class="page-sub-title">Test Range Data Table<span>
                                <div id="add_row" class="btn btn-outline-secondary ml-3"> Add Range
                                    <i class="fa fa-plus pl-2" aria-hidden="true"></i>
                                </div>
                            </span>
                        </div>
                        <table id="test_data_range_table" class="table table-bordered hover" style="width:100%">
                            <thead>
                                <tr class="table-title">
                                    <th style="width: 15%;">Gender</th>
                                    <th>Min Age</th>
                                    <th>Max Age</th>
                                    <th>Min Range</th>
                                    <th>Max Range</th>
                                    <th>Condition</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($testData->ranges as $range)
                                <tr>
                                    <td>
                                        <select name="ranges[{{ $loop->index }}][gender]" class="form-control"
                                            id="gender_{{ $loop->index }}" required>
                                            <option value="M" @if ($range->gender=='M') selected @endif>Male
                                            </option>
                                            <option value="F" @if ($range->gender=='F') selected @endif>Female
                                            </option>
                                        </select>
                                    </td>
                                    <td>
                                        <input name="ranges[{{ $loop->index }}][age_min]"
                                            id="age_min_{{ $loop->index }}" type="text" class="form-control"
                                            value="{{$range->age_min}}" required>
                                    </td>
                                    <td>
                                        <input name="ranges[{{ $loop->index }}][age_max]"
                                            id="age_max_{{ $loop->index }}" type="text" class="form-control"
                                            value="{{$range->age_max}}" required>
                                    </td>
                                    <td>
                                        <input name="ranges[{{ $loop->index }}][range_min]"
                                            id="range_min_{{ $loop->index }}" type="text" class="form-control"
                                            value="{{ (float) $range->range_min}}" required>
                                    </td>
                                    <td>
                                        <input name="ranges[{{ $loop->index }}][range_max]"
                                            id="range_max_{{ $loop->index }}" type="text" class="form-control"
                                            value="{{ (float) $range->range_max}}" required>
                                    </td>
                                    <td>
                                        <input name="ranges[{{ $loop->index }}][condition]"
                                            id="range_condition_{{ $loop->index }}" type="text" class="form-control"
                                            value="{{$range->condition}}" required>
                                    </td>
                                    <td>
                                        <a type='button' id='delete_row_{{ $loop->index }}' class='btn btn-light'
                                            onclick='preferredRangeDelete(this);'>
                                            <i class='fa fa-trash-o' aria-hidden='true'></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Range Table -->
            </form>
            <div class="form-group d-flex justify-content-end mt-4">
                <button type="button" class="btn btn-secondary" onclick="window.history.back()">Close</button>
                <button type="submit" class="btn btn-primary ml-2" id="test_data_save_btn">
                    Update Test Data
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    .add-new-range-btn {
        display: none;
    }
</style>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
<script src="https://unpkg.com/imask"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script src="{{asset('js/test-data/edit.js')}}"></script>
@endpush