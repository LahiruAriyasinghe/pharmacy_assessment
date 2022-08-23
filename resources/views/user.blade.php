@extends('layouts.app')

@section('title', 'Manage Other Services')

@section('content')
<div class="container">
    <div class="page-title-btn">
        <div class="page-title-with-button"><span><img class="page-title-icon"
                    src="{{ asset('img/pharmacy.svg') }}"></span>Ayubo Pharmacy</div>
        <Button type="button" class="btn btn-primary" onclick="window.location='{{ route("create_prescription") }}'">New
            Prescription</Button>
    </div>
    <hr>
</div>

<div class="container">
    <div class="row">
        <div class="col-12">
        <table class="table table-bordered yajra-datatable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>User Name</th>
                    <th>Note</th>
                    <th>Address</th>
                    <th>Accept/Rejected</th>
                    <th>Time</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
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
var table = null;

$(document).ready(function() {

    var table = $('.yajra-datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('user.list') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'user', name: 'user_id'},
            {data: 'note', name: 'note'},
            {data: 'address', name: 'address'},
            {data: 'quotaion', name: 'quotaion'},
            {data: 'time', name: 'time'},
            {data: 'action', name: 'action'},
        ],
        
    });
  
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