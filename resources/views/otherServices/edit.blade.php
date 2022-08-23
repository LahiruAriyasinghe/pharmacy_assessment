@extends('layouts.app')

@section('title', 'Edit Services')

@section('content')
<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Service</div>

                <div class="card-body">
                    <form action="{{route('other-services.update', $service)}}" method="post" id="services_form">
                        @csrf
                        @method('PUT')
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>

                            <div class="col-md-6">
                            <input id="name" type="text" class="form-control" name="name" value="{{$service->name}}" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="fee" class="col-md-4 col-form-label text-md-right">Service Fee</label>

                            <div class="col-md-6">
                                <input id="fee" type="text" class="form-control" name="fee" value="{{$service->fee}}">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="button" class="btn btn-secondary" onclick="window.history.back()">Close</button>
                                <button type="submit" class="btn btn-primary" id="service_save_btn">
                                    Update Service
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
<script src="{{asset('js/otherServices/edit.js')}}"></script>
@endpush