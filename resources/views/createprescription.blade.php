@extends('layouts.app')

@section('title', 'Create Prescription')

@section('content')
<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">New Prescription</div>
                <div class="card-body">
                <form action="{{ route('store_prescription') }}" method="POST" id="file-upload" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label for="note" class="col-md-4 col-form-label text-md-right">Note</label>
                            <div class="col-md-6">
                            <div class="row">
                                <textarea id="note" name="note"  class="form-control" rows="3" required></textarea>
                            </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="address" class="col-md-4 col-form-label text-md-right">Address</label>
                            <div class="col-md-6">
                            <div class="row">
                                <input id="address" type="address" class="form-control" name="address" required>
                            </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="address" class="col-md-4 col-form-label text-md-right">Delivery Time</label>
                            <div class="col-md-6">
                            <div class="row">
                                <input name="time" id="time" type="date" class="form-control" placeholder="Delivery Time" required/>
                            </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="image1" class="col-md-4 col-form-label text-md-right">Upload Prescription 1</label>
                            <div class="col-md-6">
                            <div class="row">
                                <input type="file" id="image1"  class="form-control" name="image1"  required>
                            </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="image2" class="col-md-4 col-form-label text-md-right">Upload Prescription 2</label>
                            <div class="col-md-6">
                            <div class="row">
                                <input id="image2" type="file" class="form-control" name="image2" >
                            </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="image3" class="col-md-4 col-form-label text-md-right">Upload Prescription 3</label>
                            <div class="col-md-6">
                            <div class="row">
                                <input id="image3" type="file" class="form-control" name="image3">
                            </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="image4" class="col-md-4 col-form-label text-md-right">Upload Prescription 4</label>
                            <div class="col-md-6">
                            <div class="row">
                                <input id="image4" type="file" class="form-control" name="image4">
                            </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="image5" class="col-md-4 col-form-label text-md-right">Upload Prescription 5</label>
                            <div class="col-md-6">
                            <div class="row">
                                <input id="image5" type="file" class="form-control" name="image5">
                            </div>
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="button" class="btn btn-secondary" onclick="window.history.back()">Close</button>
                                <button type="submit" class="btn btn-primary" id="product_save_btn">
                                    Upload Prescription
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

$(document).ready(function() {
    $('#file-upload').submit(function(e) {
        e.preventDefault();
        let formData = new FormData(this);

        $.ajax({
            type:'POST',
            url: "{{ route('store_prescription') }}",
            data: formData,
            contentType: false,
            processData: false,
            success: (response) => {
                console.log(response);
                if (response.success) {
                    window.location.href = response.url;
                }
            },
            error: function(response){
                alert('Prescription has not been created successfully');
            }
       });
    });
});


</script>



@endpush