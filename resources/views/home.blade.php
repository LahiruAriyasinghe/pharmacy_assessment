@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
    <div class="page-title">Welcome to <span class="title-system">{{ config('app.name', 'AyuboHealth') }}
            System</span>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-11">
            <!-- @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
            @endif

            {{ __('You are logged in!') }} -->
            <hr>
            <div class="row mb-3">
                @can('create invoice', App\User::class)
                <div class="col-md-12">
                    <a class="btn-squre m-2 shadow-sm w-100" href="{{route('invoice')}}" role="button">
                        <img class="tile-icon" src="{{ asset('img/cash.svg') }}">
                        <div class="tile-title">Create Bill </div>
                    </a>
                </div>
                @endcan
            </div>
            <div class="row mb-3">
                @can('view session', App\User::class)
                <div class="col-md-6">
                    <a class="btn-squre-regular m-2 shadow-sm w-100" href="{{route('sessions.index')}}" role="button">
                        <img class="tile-icon" src="{{ asset('img/doctor.svg') }}">
                        <div class="tile-title">Channel Sessions</div>
                    </a>
                </div>
                @endcan

                <!-- @can('view user', App\User::class)
                <div class="col-md-6">
                    <a class="btn-squre-regular  m-2 shadow-sm w-100" href="{{route('users.index')}}" role="button">
                        <img class="tile-icon" src="{{ asset('img/group.svg') }}">
                        <div class="tile-title">Manage Users</div>
                    </a>
                </div>
                @endcan -->

                <!-- @can('view role', App\User::class)
                <div class="col-md-6">
                    <a class="btn-squre-regular m-2 w-100" href="{{route('roles.index')}}" role="button">
                        <img class="tile-icon" src="{{ asset('img/role.svg') }}">
                        <div class="tile-title">Manage Roles</div>
                    </a>
                </div>
                @endcan -->

                <!-- @can('view doctor', App\User::class)
                <div class="col-md-6">
                    <a class="btn-squre-regular m-2 w-100" href="{{route('specialties.index')}}" role="button">
                        <img class="tile-icon" src="{{ asset('img/specialist.svg') }}">
                        <div class="tile-title">Specialities</div>
                    </a>
                </div>
                @endcan -->

                <!-- @can('view service', App\User::class)
                <div class="col-md-6">
                    <a class="btn-squre-regular m-2 w-100" href="{{route('other-services.index')}}" role="button">
                        <img class="tile-icon" src="{{ asset('img/veterinary.svg') }}">
                        <div class="tile-title">Other Services</div>
                    </a>
                </div>
                @endcan -->

                <!-- @can('create invoice', App\User::class)
                <div class="col-md-6">
                    <a class="btn-squre-regular m-2 w-100" href="{{route('reports.cashier.index')}}" role="button">
                        <img class="tile-icon" src="{{ asset('img/finance-report.svg') }}">
                        <div class="tile-title">Cashier Reports</div>
                    </a>
                </div>
                @endcan -->

                <!-- @can('view all cash reports', App\User::class)
                <div class="col-md-6">
                    <a class="btn-squre-regular m-2 w-100" href="{{route('reports.admin.index')}}" role="button">
                        <img class="tile-icon" src="{{ asset('img/admin-report.svg') }}">
                        <div class="tile-title">Reports (Admin)</div>
                    </a>
                </div>
                @endcan -->
                @can('update patient lab report', App\User::class)
                <div class="col-md-6">
                    <a class="btn-squre-regular  m-2 shadow-sm w-100" href="{{route('lab-reports.results.index')}}"
                        role="button">
                        <img class="tile-icon" src="{{ asset('img/result.svg') }}">
                        <div class="tile-title">Lab Report Results</div>
                    </a>
                </div>
                @endcan

                @can('create invoice', App\User::class)
                <div class="col-md-6">
                    <a class="btn-squre-regular m-2 w-100" href="{{route('invoice-reverse')}}" role="button">
                        <img class="tile-icon" src="{{ asset('img/undo.svg') }}">
                        <div class="tile-title">Reverse Invoice</div>
                    </a>
                </div>
                @endcan

                @can('create invoice', App\User::class)
                <div class="col-md-6">
                    <a class="btn-squre-regular m-2 w-100" id="last_invoice_btn" role="button">
                        <img class="tile-icon" src="{{ asset('img/reverse.svg') }}">
                        <div class="tile-title">Print Last Invoice</div>
                    </a>
                </div>
                @endcan

                <!-- @can('view product', App\User::class)
                <div class="col-md-6">
                    <a class="btn-squre-regular m-2 w-100" href="{{route('products.index')}}" role="button">
                        <img class="tile-icon" src="{{ asset('img/pharmacy.svg') }}">
                        <div class="tile-title">Pharmacy</div>
                    </a>
                </div>
                @endcan -->

                <!-- @can('create lab report', App\User::class)
                <div class="col-md-6">
                    <a class="btn-squre-regular  m-2 shadow-sm w-100" href="{{route('lab-reports.index')}}"
                        role="button">
                        <img class="tile-icon" src="{{ asset('img/result.svg') }}">
                        <div class="tile-title">Lab Reports</div>
                    </a>
                </div>
                @endcan -->

                <!-- @can('create test data category', App\User::class)
                <div class="col-md-6">
                    <a class="btn-squre-regular m-2 w-100" href="{{route('lab-reports.categories.index')}}"
                        role="button">
                        <img class="tile-icon" src="{{ asset('img/undo.svg') }}">
                        <div class="tile-title">Categories</div>
                    </a>
                </div>
                @endcan

                @can('create unit', App\User::class)
                <div class="col-md-6">
                    <a class="btn-squre-regular m-2 w-100" href="{{route('units.index')}}" role="button">
                        <img class="tile-icon" src="{{ asset('img/undo.svg') }}">
                        <div class="tile-title">Units</div>
                    </a>
                </div>
                @endcan

                @can('create result category', App\User::class)
                <div class="col-md-6">
                    <a class="btn-squre-regular m-2 w-100" href="{{route('test-data.result-categories.index')}}"
                        role="button">
                        <img class="tile-icon" src="{{ asset('img/undo.svg') }}">
                        <div class="tile-title">Result Categories</div>
                    </a>
                </div>
                @endcan

                @can('create test data category', App\User::class)
                <div class="col-md-6">
                    <a class="btn-squre-regular m-2 w-100" href="{{route('test-data.categories.index')}}" role="button">
                        <img class="tile-icon" src="{{ asset('img/undo.svg') }}">
                        <div class="tile-title">Test Data Categories</div>
                    </a>
                </div>
                @endcan

                @can('create test data', App\User::class)
                <div class="col-md-6">
                    <a class="btn-squre-regular m-2 w-100" href="{{route('test-datas.index')}}" role="button">
                        <img class="tile-icon" src="{{ asset('img/undo.svg') }}">
                        <div class="tile-title">Test Data</div>
                    </a>
                </div>
                @endcan -->

            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script>
// $(function() {
//     $('.dropdown-toggle').dropdown();

// });

$('#last_invoice_btn').click(function(e) {
    e.preventDefault();

    Swal.fire({
        title: 'Are you sure?',
        text: "Do you want to re-print last invoice?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, print invoice!'
    }).then((result) => {
        if (result.value) {
            // request last invoice
            $.ajax({
                type: "GET",
                url: "{{route('invoices.last-print')}}",
                success: function(response) {
                    if (response.success) {
                        window.open(response.data.invoice_pdf_url);
                        return;
                    }

                    Swal.fire({
                        icon: 'warning',
                        title: 'Oops...',
                        text: response.msg,
                    });
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
    });
});
</script>
@endpush

@push('styles')
<style>
/* .btn-squre {
        height: 250px;
        width: 250px !important;
        display: flex !important;
        flex-direction: column;
        cursor: pointer;
        justify-content: center;
        align-items: center;
        padding: 16px;
        border-radius: 7px;
        background: #1ca0f4;
        border: 2px solid #1ca0f4;
    }

    .btn-squre-regular {
        height: 250px;
        width: 250px !important;
        display: flex !important;
        flex-direction: column;
        cursor: pointer;
        justify-content: center;
        align-items: center;
        padding: 16px;
        border-radius: 7px;
        background: #d1dfe6;
        border: 2px solid #c3cfd6;
    }

    .tile-title {
        font-size: 24px;
        font-weight: 400;
        padding-top: 16px;
        padding-left: 0 !important;
        color: #fff;
    } */
</style>
@endpush