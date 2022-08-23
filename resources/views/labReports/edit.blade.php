@extends('layouts.app')

@section('title', 'Edit Lab Reports')

@section('content')
<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Report</div>

                <div class="card-body">
                    <form action="{{route('lab-reports.update', $report)}}" method="post" id="report_form">
                        @csrf
                        @method('PUT')
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{$report->name}}"
                                    required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="acronym" class="col-md-4 col-form-label text-md-right">Acronym</label>

                            <div class="col-md-6">
                                <input id="acronym" type="text" class="form-control" name="acronym"
                                    value="{{$report->acronym}}" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="fee" class="col-md-4 col-form-label text-md-right">Service Fee</label>
                            <div class="col-md-6">
                                <input id="fee" type="text" class="form-control" name="fee" value="{{$report->fee}}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="lab_report_categories_id" class="col-md-4 col-form-label text-md-right">Report
                                Category</label>
                            <div class="col-md-6">
                                <select class="form-control" id="lab_report_categories_id"
                                    name="lab_report_categories_id" style="width: 100%">
                                    <option value="" disabled>Select Report Category</option>
                                    @foreach ($labReportCategories as $cateogories)
                                    <option value="{{$cateogories->id}}" @if($cateogories->id ==
                                        $report->lab_report_categories_id) selected @endif>{{$cateogories->name}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="reference_report" class="col-md-4 col-form-label text-md-right">
                                Reference Report
                            </label>
                            <div class="col-md-6">
                                <select class="form-control" id="reference_report" name="reference_report"
                                    style="width: 100%">
                                    <option value="">Not a Reference Report</option>
                                    @foreach ($labReports as $labReport)
                                        @if ($labReport->id == $report->id)
                                            @continue
                                        @endif
                                        <option value="{{$labReport->id}}" @if($labReport->id ==
                                            $report->reference_report) selected @endif>{{$labReport->name}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="test_datas" class="col-md-4 col-form-label text-md-right">Test Data</label>
                            <div class="col-md-6">
                                <select class="form-control" id="test_datas" name="test_datas[]" multiple="multiple"
                                    style="width: 100%">
                                    <option value="" disabled>Select Test Data</option>
                                    @foreach ($testDatas as $testData)
                                    @if(in_array($testData->id, $selectedTestDatas))
                                    <option value="{{$testData->id}}" selected>{{ $testData->name }}</option>
                                    @else
                                    <option value="{{$testData->id}}">{{$testData->name}}</option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="button" class="btn btn-secondary"
                                    onclick="window.history.back()">Close</button>
                                <button type="submit" class="btn btn-primary" id="report_save_btn">
                                    Update Report
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
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script src="https://unpkg.com/imask"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script src="{{asset('js/labReports/edit.js')}}"></script>
<script>
    $(document).ready(function() {
        $('#test_datas').select2({
            maximumSelectionLength: 20,
            closeOnSelect: false
        });

        $("#test_datas").on("select2:select", function (evt) {
            var element = evt.params.data.element;
            var $element = $(element);
            
            $element.detach();
            $(this).append($element);
            $(this).trigger("change");
        });
    });
</script>

@endpush

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
@endpush