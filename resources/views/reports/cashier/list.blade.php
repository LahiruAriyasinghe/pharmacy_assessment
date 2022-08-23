@extends('layouts.app')

@section('title', 'Cashier Reports')

@section('content')
<div class="container">
    <div class="page-title-btn">
        <div class="page-title-with-button"><span><img class="page-title-icon"
                    src="{{ asset('img/finance-report.svg') }}"></span>Cashier Reports</div>
    </div>
    <hr>
</div>

<div class="container">
    <div class="row">
        <div class="col-4">
            <Button type="button" class="btn btn-primary" onclick="getCashierCashOnHandPDFReport()">Get Report</Button>
        </div>
        <div class="col-8 d-flex align-items-baseline justify-content-end">
            <p class="mr-4">Total transactions</p>
            (LKR)
            <h2 class="ml-2">{{number_format( $cashInHand , 2, '.', ',')}}</h2>
        </div>
    </div>
</div>
<div class="container">
    <hr>
    <div class="row">
        <div class="col-12">
            <table id="transactions_table" class="table table-bordered hover" style="width:100%">
                <thead>
                    <tr class="table-title">
                        <th>Id</th>
                        <th>Invoice</th>
                        <th>Type</th>
                        <th>Credit</th>
                        <th>Created At</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script>
var table = null;

$(document).ready(function() {

    table = $('#transactions_table').DataTable({
        "ajax": "{{route('resources.reports.cashier.index')}}",
        "columns": [{
                "data": "invoice_id"
            },
            {
                "data": "invoice_name.name",
                "defaultContent": "N/A"
            },
            {
                "data": "type"
            },
            {
                "data": "credit",
                "className": "text-right"
            },
            {
                "data": "created_at"
            },
        ],
        "order": [
            [4, "desc"]
        ],
        "columnDefs": [{
                "targets": 2,
                "data": null,
                "render": function(data, type, row, meta) {
                    let text = data;
                    if (row.reversed) {
                        text = 'reverse';
                    }
                    return toTitleCase(text);
                }
            },
            {
                "targets": 3,
                "data": null,
                "render": function(data, type, row, meta) {
                    let amount = row.credit;
                    if (row.debit > 0) {
                        amount = `(${row.debit})`;
                        if (row.credit > 0) {
                            amount = `Error`;
                        }
                    }
                    return amount;
                }
            },
        ],
    });
});


function toTitleCase(str) {
    if (str.trim() == '') {
        return '';
    }

    return str.replace(
        /\w\S*/g,
        function(txt) {
            return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
        }
    );
}

function getCashierCashOnHandPDFReport() {
    $.ajax({
        type: "GET",
        url: "{{ route('reports.cashier.daily') }}",
        success: function(response) {
            console.log(response);

            if ("success" in response) {
                window.open(response.data.cash_in_hand_url);
                return;
            }

            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Something went wrong!',
            });
            return;
        },
        error: function(request, status, error) {
            console.error("error :>> ", request.responseText);
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Something went wrong!',
            });
            return;
        },
    });
}
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