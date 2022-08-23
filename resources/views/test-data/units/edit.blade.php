@extends('layouts.app')

@section('title', 'Edit Units')

@section('content')
<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Units</div>

                <div class="card-body">
                    <form action="{{route('units.update', $unit)}}" method="post" id="units_form">
                        @csrf
                        @method('PUT')
                        <div class="form-group row">
                            <label for="unit" class="col-md-4 col-form-label text-md-right">Unit</label>

                            <div class="col-md-6">
                                <input id="unit" type="text" class="form-control" name="unit" value="{{$unit->unit}}"
                                    required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{$unit->name}}"
                                    required>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="button" class="btn btn-secondary"
                                    onclick="window.history.back()">Close</button>
                                <button type="submit" class="btn btn-primary" id="unit_save_btn">
                                    Update Unit
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
<script src="{{asset('js/units/edit.js')}}"></script>
@endpush