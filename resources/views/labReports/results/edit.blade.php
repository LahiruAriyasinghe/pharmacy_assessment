@extends('layouts.app')

@section('title', 'Edit Lab Report Result')

@section('content')
<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Lab Report Result</div>

                <div class="card-body">
                    <form action="{{route('lab-reports.results.update', $result)}}" method="post" id="lab_results_form">
                        @csrf
                        @method('PUT')

                        <div class="form-group row">
                            <label for="note" class="col-md-4 col-form-label text-md-right">Note</label>

                            <div class="col-md-6">
                                <input id="note" type="text" class="form-control" name="note"
                                    value="{{$result->result->note}}">
                            </div>
                        </div>

                        @foreach ($result->result->data as $key => $value)

                        <div class="form-group row">
                            @php
                            $resultCategory = \App\TestDataResultCategory::find($value->result_category_id);
                            @endphp

                            @if ($resultCategory->result_category === 'Numerical')

                            <label for="{{ $value->id }}"
                                class="col-md-4 col-form-label text-md-right">{{ $value->name }}</label>
                            <div class="col-md-6">
                                <div class="input-group-append">
                                    <input type="number" name="test_datas[{{ $value->id }}]" id="{{ $value->id }}"
                                        value="{{ $value->result }}" required>
                                    @if (isset($value->unit))
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="basic-addon2">{{ $value->unit }}</span>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            @elseif ($resultCategory->result_category === 'Text')

                            <label for="{{ $value->id }}"
                                class="col-md-4 col-form-label text-md-right">{{ $value->name }}</label>
                            <div class="col-md-6">
                                <div class="input-group-append">
                                    <textarea class="form-control" id="description" rows="3"
                                        name="test_datas[{{ $value->id }}]">{{ $value->result }}</textarea>
                                </div>
                            </div>

                            @else

                            <label for="{{ $value->id }}"
                                class="col-md-4 col-form-label text-md-right">{{ $value->name }}</label>
                            <div class="col-md-6">
                                <select class="form-control" name="test_datas[{{ $value->id }}]" id="{{ $value->id }}"
                                    required>
                                    @php
                                    $resultCategoryTypes =
                                    \App\TestDataResultCategory::getResultCategoryTypes($value->result_category_id);
                                    @endphp
                                    @foreach ($resultCategoryTypes as $resultCategory)
                                    <option value="{{ $resultCategory }}" @if ($value->result == $resultCategory)
                                        selected @endif>{{ $resultCategory }}</option>
                                    @endforeach
                                </select>
                            </div>

                            @endif

                        </div>
                        @endforeach

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="button" class="btn btn-secondary"
                                    onclick="window.history.back()">Close</button>
                                <button type="submit" class="btn btn-primary" id="result_save_btn">
                                    Update Results
                                </button>
                                <button type="button" class="btn btn-success" id="result_complete_btn">
                                    Complete
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
<script src="{{asset('js/labReports/results/edit.js')}}"></script>
@endpush