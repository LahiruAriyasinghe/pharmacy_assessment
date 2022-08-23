@extends('layouts.app')

@section('title', 'Reverse Invoice')

@section('content')
<div class="container">
    <div class="page-title-btn">
        <div class="page-title-with-button"><span><img class="page-title-icon"
                    src="{{ asset('img/undo.svg') }}"></span>Reverse Invoice</div>
    </div>
    <hr>
</div>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('invoice-reverse.store')}}" method="POST" id="reverse_invoice_form"
                        autocomplete="off" novalidate>
                        @csrf
                        <div class="form-group row">
                            <label for="invoice_id" class="col-md-4 col-form-label text-md-right">Invoice Id</label>

                            <div class="col-md-6">
                                <input id="invoice_id" type="text" class="form-control" name="invoice_id"
                                    autocomplete="off">
                                <small id="invoice_id" class="form-text text-muted">
                                    Note: you can only reverse invoices created by you withing today.
                                </small>
                            </div>
                        </div>
                        <br>
                        <div class="form-group row">
                            <label for="admin_id" class="col-md-4 col-form-label text-md-right">Admin User</label>

                            <div class="col-md-6">
                                <select class="form-control" id="admin_id" name="admin_id">
                                    @foreach ($admins as $user)
                                    <option value="{{$user->id}}">{{$user->username}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="admin_password" class="col-md-4 col-form-label text-md-right">Password</label>

                            <div class="col-md-6">
                                <input id="admin_password" type="password" class="form-control" name="admin_password"
                                    autocomplete="one-time-code">
                            </div>
                        </div>

                        <div class="form-group row mb-0">

                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary" id="invoice_reverse_save_btn">
                                    Reverse
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script src="https://unpkg.com/imask"></script>
<script src="{{asset('js/invoices-reverse/create.js')}}"></script>
<script type="text/javascript">
jQuery.extend(jQuery.expr[':'], {
    focusable: function(el, index, selector) {
        return $(el).is('a, button, :input, [tabindex]');
    }
});

$(document).on('keypress', 'input,select', function(e) {

    let id = $(this).attr('id');

    if (id == 'opd_number' | id == 'other_number' | id == 'lab_number' | id == 'chnl_number') {
        return;
    }

    if (e.which == 13) {
        e.preventDefault();
        // Get all focusable elements on the page
        var $canfocus = $(':focusable');
        var index = $canfocus.index(this) + 1;
        if (index >= $canfocus.length) index = 0;
        $canfocus.eq(index).focus();
    }
});
</script>
@endpush

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<style>
.tab-pane {
    background-color: white;
    padding: 16px;
}

.nav-tabs .nav-link.active,
.nav-tabs .nav-item.show .nav-link {
    color: #fff;
    background-color: #1ca0f4;
    border-color: #1ca0f4;
    font-size: 18px;
}

.nav-tabs .nav-link,
.nav-tabs .nav-item.show .nav-link {
    color: #595959;
    background-color: #F5F5F5;
    border-color: #D9D9D9;
}

.form-control {
    display: block;
    /* width: 18rem !important; */
    height: calc(1.6em + 0.75rem + 2px);
    padding: 0.375rem 0.75rem;
    font-size: 16px;
    font-weight: 400;
    line-height: 1.6;
    color: #495057;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    border-radius: 0.25rem;
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}

.btn {
    min-width: 100px;
}

.form-control-serach {
    display: block;
    height: calc(1.6em + 0.75rem + 2px);
    padding: 0.375rem 0.75rem;
    font-size: 16px;
    font-weight: 400;
    line-height: 1.6;
    color: #1d1d1d;
    background-color: #dee2e5;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    border-radius: 0.5rem;
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}

.form-inline {
    justify-content: flex-end;
}

.form-label {
    font-size: 18px;
}

.btn-primary,
.btn-secondary {
    font-size: 1.2rem;
}

.input-hidden {
    position: absolute;
    left: -9999px;
}

input[type=radio]:checked+label>img {
    border: 3px solid #1ca0f4;
}

/* Stuff after this is only to make things more pretty */
input[type=radio]+label>img {
    width: 150px;
    height: 150px;
    transition: 100ms all;
    cursor: pointer;
}
</style>
@endpush