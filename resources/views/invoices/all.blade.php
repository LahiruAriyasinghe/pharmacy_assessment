@extends('layouts.app')

@section('title', 'Billing')

@section('content')

<div class="container">
    <div class="row justify-content-center">

        <div class="col-md-12">

            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="pills-opd-tab" data-toggle="pill" href="#opd_tab" role="tab"
                        aria-controls="pills-opd" aria-selected="true">OPD</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pills-lab-tab" data-toggle="pill" href="#lab_tab" role="tab"
                        aria-controls="pills-lab" aria-selected="false">Lab</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pills-channeling-tab" data-toggle="pill" href="#channelling_tab" role="tab"
                        aria-controls="pills-channeling" aria-selected="false">Channel</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pills-product-tab" data-toggle="pill" href="#product_tab" role="tab"
                        aria-controls="pills-product" aria-selected="false">Pharmacy</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pills-other-tab" data-toggle="pill" href="#other_tab" role="tab"
                        aria-controls="pills-other" aria-selected="false">Services</a>
                </li>

            </ul>

            <hr><br>

            <div class="tab-content" id="nav-tabContent">
                <!-- opd invoice section -->
                <div class="tab-pane fade show active" id="opd_tab" role="tabpanel" aria-labelledby="pills-opd-tab">
                    <form action="{{route('patients.show', ['patient' => 'xx'])}}" method="POST" id="opd_patient_form">
                        @csrf
                        <div class="input-group mb-3 col-sm-6 ml-0 pl-0">
                            <input type="text" class="form-control" placeholder="Patient Number" id="opd_number"
                                name="number">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="submit"
                                    id="opd_number_search_btn_active">Search</button>
                                <button class="btn btn-outline-secondary" type="button"
                                    id="opd_number_search_btn_inactive" style="display: none;" disabled>
                                    <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                                    Serching...
                                </button>
                                <button type="button" class="btn btn-outline-danger" id="opd_clear_info_btn"
                                    style="display: none;" data-toggle="tooltip" data-placement="top"
                                    title="Clear selected user information">Clear</button>
                            </div>
                        </div>
                    </form>

                    <hr>

                    <form action="{{route('invoices.opd.store')}}" method="POST" id="opd_invoice_form">
                        @csrf
                        <input type="hidden" id="opd_patient_id" name="patient_id">

                        <div class="form-group row">
                            <label for="opd_title" class="col-sm-2 col-form-label">Name</label>
                            <div class="col-sm-2">
                                <select class="form-control" id="opd_title" name="title" autofocus>
                                    <option value="Mr" selected>Mr</option>
                                    <option value="Miss">Miss</option>
                                    <option value="Mrs">Mrs</option>
                                    <option value="Dr">Dr</option>
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="opd_first_name" name="first_name"
                                    placeholder="First name">
                            </div>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="opd_last_name" name="last_name"
                                    placeholder="Last name">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="opd_contact" class="col-sm-2 col-form-label">Contact</label>
                            <div class="col-sm-4">
                                <input id="opd_contact" type="text" class="form-control" name="contact" required>
                            </div>
                            <label for="opd_age" class="col-sm-1 col-form-label">Age</label>
                            <div class="col-sm-2">
                                <input id="opd_age" type="text" class="form-control text-right" name="age" required>
                            </div>
                            <label for="opd_gender" class="col-sm-1 col-form-label">Gender</label>
                            <div class="col-sm-2">
                                <select class="form-control" id="opd_gender" name="gender">
                                    <option value="M" selected>Male</option>
                                    <option value="F">Female</option>
                                    <option value="O">Other</option>
                                </select>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row">
                            <label for="opd_doctor" class="col-sm-2 col-form-label">Doctor</label>
                            <div class="col-sm-6">
                                <select class="form-control" id="opd_doctor" name="doctor">
                                    @foreach ($doctors as $doctor)
                                    <option value="{{$doctor->id}}" data-fee="{{$doctor->fee}}" @if ($loop->first)
                                        selected @endif>{{$doctor->user->first_name}} {{$doctor->user->last_name}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <input type="hidden" id="opd_doctor_fee" name="doctor_fee">
                        </div>
                        <div class="form-group row">
                            <label for="opd_drug_fee" class="col-sm-2 col-form-label">Drugs Fee</label>
                            <div class="col-sm-4">
                                <input id="opd_drug_fee" type="text" class="form-control text-right" name="drug_fee"
                                    value="0.00">
                            </div>

                        </div>
                        <div class="form-group row">
                            <label for="opd_hospital_fee" class="col-sm-2 col-form-label">Hospital Fee</label>
                            <div class="col-sm-4">
                                <input id="opd_hospital_fee" type="text" class="form-control readonly text-right"
                                    name="hospital_fee" tabindex="-1"
                                    value="{{$hospital->hospitalFee()->where('invoice_type_id', 1)->first()->fee}}"
                                    readonly>
                            </div>
                            <div class="align-items-lg-baseline col-sm-6 d-flex justify-content-end">
                                <h4 class="mr-3">Total</h4>
                                <h1 id="opd_total_val">00.00</h1>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="opd_payment_card" class="col-sm-2 col-form-label">Payment method</label>
                            <div class="form-check col-sm-2 ml-3">
                                <input class="form-check-input" type="radio" name="payment_method" id="opd_payment_card"
                                    value="card">
                                <label class="form-check-label" for="payment_card">
                                    Credit Card
                                </label>
                            </div>
                            <div class="form-check col-sm-2">
                                <input class="form-check-input" type="radio" name="payment_method" id="opd_payment_cash"
                                    value="cash" checked>
                                <label class="form-check-label" for="payment_cash">
                                    Cash
                                </label>
                            </div>
                        </div>
                        <input type="hidden" id="opd_total" name="total">

                        <div class="form-group row d-flex justify-content-end">
                            <button type="btn" id="opd_cancel_btn" class="btn btn-secondary mr-3">Cancel</button>
                            <button type="submit" class="btn btn-primary" id="opd_paid_btn">Pay</button>
                        </div>
                    </form>
                </div>
                <!-- end opd invoice section -->

                <!-- lab invoice section -->
                <div class="tab-pane fade" id="lab_tab" role="tabpanel" aria-labelledby="pills-lab-tab">
                    <form action="{{route('patients.show', ['patient' => 'xx'])}}" method="POST" id="lab_patient_form">
                        @csrf
                        <div class="input-group mb-3 col-sm-6 ml-0 pl-0">
                            <input type="text" class="form-control" placeholder="Patient Number" id="lab_number"
                                name="number">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="submit"
                                    id="lab_number_search_btn_active">Search</button>
                                <button class="btn btn-outline-secondary" type="button"
                                    id="lab_number_search_btn_inactive" style="display: none;" disabled>
                                    <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                                    Serching...
                                </button>
                                <button type="button" class="btn btn-outline-danger" id="lab_clear_info_btn"
                                    style="display: none;" data-toggle="tooltip" data-placement="top"
                                    title="Clear selected user information">Clear</button>
                            </div>
                        </div>
                    </form>

                    <hr>

                    <form action="{{route('invoices.lab.store')}}" method="POST" id="lab_invoice_form">
                        @csrf
                        <input type="hidden" id="lab_patient_id" name="patient_id">

                        <div class="form-group row">
                            <label for="lab_title" class="col-sm-2 col-form-label">Name</label>
                            <div class="col-sm-2">
                                <select class="form-control" id="lab_title" name="title" autofocus>
                                    <option value="Mr" selected>Mr</option>
                                    <option value="Miss">Miss</option>
                                    <option value="Mrs">Mrs</option>
                                    <option value="Dr">Dr</option>
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="lab_first_name" name="first_name"
                                    placeholder="First name">
                            </div>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="lab_last_name" name="last_name"
                                    placeholder="Last name">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="lab_contact" class="col-sm-2 col-form-label">Contact</label>
                            <div class="col-sm-4">
                                <input id="lab_contact" type="text" class="form-control" name="contact" required>
                            </div>
                            <label for="lab_age" class="col-sm-1 col-form-label">Age</label>
                            <div class="col-sm-2">
                                <input id="lab_age" type="text" class="form-control text-right" name="age" required>
                            </div>
                            <label for="lab_gender" class="col-sm-1 col-form-label">Gender</label>
                            <div class="col-sm-2">
                                <select class="form-control" id="lab_gender" name="gender">
                                    <option value="M" selected>Male</option>
                                    <option value="F">Female</option>
                                    <option value="O">Other</option>
                                </select>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row">
                            <label for="lab_report" class="col-sm-2 col-form-label">Lab Reports</label>
                            <div class="col-sm-6">
                                <select class="form-control" id="lab_report" name="reports[]" multiple="multiple"
                                    style="width: 100%">
                                    @foreach ($labReports as $report)
                                    <option value="{{$report->id}}" data-fee="{{$report->fee}}" @if ($loop->first)
                                        selected @endif>{{$report->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <input type="hidden" id="lab_report_fee" name="report_fee">
                        </div>
                        <div class="form-group row">
                            <label for="reference_report_check" class="col-sm-2 col-form-label">Referance Report</label>
                            <div class="form-check col-sm-2 ml-3">
                                <input class="form-check-input" type="checkbox" name="reference_report_check" value="1"
                                    id="reference_report_check">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="lab_hospital_fee" class="col-sm-2 col-form-label">Hospital Fee</label>
                            <div class="col-sm-4">
                                <input id="lab_hospital_fee" type="text" class="form-control readonly text-right"
                                    name="hospital_fee" tabindex="-1"
                                    value="{{$hospital->hospitalFee()->where('invoice_type_id', 3)->first()->fee}}"
                                    readonly>
                            </div>
                            <div class="align-items-lg-baseline col-sm-6 d-flex justify-content-end">
                                <h4 class="mr-3">Total</h4>
                                <h1 id="lab_total_val">LKR 1500.00</h1>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="lab_payment_card" class="col-sm-2 col-form-label">Payment method</label>
                            <div class="form-check col-sm-2 ml-3">
                                <input class="form-check-input" type="radio" name="payment_method" id="lab_payment_card"
                                    value="card">
                                <label class="form-check-label" for="payment_card">
                                    Credit Card
                                </label>
                            </div>
                            <div class="form-check col-sm-2">
                                <input class="form-check-input" type="radio" name="payment_method" id="lab_payment_cash"
                                    value="cash" checked>
                                <label class="form-check-label" for="payment_cash">
                                    Cash
                                </label>
                            </div>
                        </div>
                        <input type="hidden" id="lab_total" name="total">

                        <div class="form-group row d-flex justify-content-end">
                            <button type="btn" id="lab_cancel_btn" class="btn btn-secondary mr-3">Cancel</button>
                            <button type="submit" class="btn btn-primary" id="lab_paid_btn">Pay</button>
                        </div>
                    </form>
                </div>
                <!-- end lab invoice section -->

                <!-- channeling invoice section -->
                <div class="tab-pane fade" id="channelling_tab" role="tabpanel" aria-labelledby="pills-channeling-tab">
                    <form action="{{route('patients.show', ['patient' => 'xx'])}}" method="POST" id="chnl_patient_form">
                        @csrf
                        <div class="input-group mb-3 col-sm-6 ml-0 pl-0">
                            <input type="text" class="form-control" placeholder="Patient Number" id="chnl_number"
                                name="number">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="submit"
                                    id="chnl_number_search_btn_active">Search</button>
                                <button class="btn btn-outline-secondary" type="button"
                                    id="chnl_number_search_btn_inactive" style="display: none;" disabled>
                                    <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                                    Serching...
                                </button>
                                <button type="button" class="btn btn-outline-danger" id="chnl_clear_info_btn"
                                    style="display: none;" data-toggle="tooltip" data-placement="top"
                                    title="Clear selected user information">Clear</button>
                            </div>
                        </div>
                    </form>

                    <hr>

                    <form action="{{route('invoices.channeling.store')}}" method="POST" id="chnl_invoice_form">
                        @csrf
                        <input type="hidden" id="chnl_patient_id" name="patient_id">

                        <div class="form-group row">
                            <label for="chnl_title" class="col-sm-2 col-form-label">Name</label>
                            <div class="col-sm-2">
                                <select class="form-control" id="chnl_title" name="title" autofocus>
                                    <option value="Mr" selected>Mr</option>
                                    <option value="Miss">Miss</option>
                                    <option value="Mrs">Mrs</option>
                                    <option value="Dr">Dr</option>
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="chnl_first_name" name="first_name"
                                    placeholder="First name">
                            </div>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="chnl_last_name" name="last_name"
                                    placeholder="Last name">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="chnl_contact" class="col-sm-2 col-form-label">Contact</label>
                            <div class="col-sm-4">
                                <input id="chnl_contact" type="text" class="form-control" name="contact" required>
                            </div>
                            <label for="chnl_age" class="col-sm-1 col-form-label">Age</label>
                            <div class="col-sm-2">
                                <input id="chnl_age" type="text" class="form-control text-right" name="age" required>
                            </div>
                            <label for="chnl_gender" class="col-sm-1 col-form-label">Gender</label>
                            <div class="col-sm-2">
                                <select class="form-control" id="chnl_gender" name="gender">
                                    <option value="M" selected>Male</option>
                                    <option value="F">Female</option>
                                    <option value="O">Other</option>
                                </select>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row">
                            <label for="chnl_doctor" class="col-sm-2 col-form-label">Doctor</label>
                            <div class="col-sm-4">
                                <select class="form-control" id="chnl_doctor" name="doctor">
                                    @foreach ($doctors as $doctor)
                                    <option value="{{$doctor->id}}" data-fee="{{$doctor->fee}}" @if ($loop->first)
                                        selected @endif>{{$doctor->user->first_name}} {{$doctor->user->last_name}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <input type="hidden" id="chnl_doctor_fee" name="doctor_fee">
                        </div>
                        <div class="form-group row">
                            <label for="chnl_session" class="col-sm-2 col-form-label">Session</label>
                            <div class="col-sm-6">
                                <select class="form-control" id="chnl_session" name="session">
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <small id="chnl_session_help" class="form-text text-muted">
                                    Note: Selected doctor doesn't assign with any session.
                                </small>
                            </div>

                        </div>
                        <div class="form-group row">
                            <label for="chnl_hospital_fee" class="col-sm-2 col-form-label">Hospital Fee</label>
                            <div class="col-sm-4">
                                <input id="chnl_hospital_fee" type="text" class="form-control readonly text-right"
                                    name="hospital_fee" tabindex="-1"
                                    value="{{$hospital->hospitalFee()->where('invoice_type_id', 2)->first()->fee}}"
                                    readonly>
                            </div>
                            <div class="align-items-lg-baseline col-sm-6 d-flex justify-content-end">
                                <h4 class="mr-3">Total</h4>
                                <h1 id="chnl_total_val">LKR 1500.00</h1>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="chnl_payment_card" class="col-sm-2 col-form-label">Payment method</label>
                            <div class="form-check col-sm-2 ml-3">
                                <input class="form-check-input" type="radio" name="payment_method"
                                    id="chnl_payment_card" value="card">
                                <label class="form-check-label" for="payment_card">
                                    Credit Card
                                </label>
                            </div>
                            <div class="form-check col-sm-2">
                                <input class="form-check-input" type="radio" name="payment_method"
                                    id="chnl_payment_cash" value="cash" checked>
                                <label class="form-check-label" for="payment_cash">
                                    Cash
                                </label>
                            </div>
                        </div>
                        <input type="hidden" id="chnl_total" name="total">

                        <div class="form-group row d-flex justify-content-end">
                            <button type="btn" id="chnl_cancel_btn" class="btn btn-secondary mr-3">Cancel</button>
                            <button type="submit" class="btn btn-primary" id="chnl_paid_btn">Pay</button>
                        </div>
                    </form>
                </div>
                <!-- end channeling invoice section -->

                <!-- pharmacy invoice section -->
                <div class="tab-pane fade" id="product_tab" role="tabpanel" aria-labelledby="pills-lab-tab">

                    <form action="{{route('invoices.product.store')}}" method="POST" id="product_invoice_form">
                        @csrf
                        <div class="form-group row">
                            <label for="product" class="col-sm-2 col-form-label">Products</label>
                            <div class="col-sm-6">
                                <div class="row">
                                    <select class="form-control" id="product" name="product[]" style="width: 100%">
                                        <option value=""></option>
                                        @foreach ($products as $product)
                                        <option value="{{$product->id}}">{{$product->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="row">
                                    <small id="select_product" class="text-danger" class="col-md-4"
                                        style="display: none">You must select a product</small>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="product_stock" class="col-sm-2 col-form-label">Batch No</label>
                            <div class="col-sm-6">
                                <div class="row">
                                    <select class="form-control" id="product_stock" name="productStocks[]"
                                        style="width: 100%">
                                        <option value=""></option>
                                        @foreach ($productStocks as $productStock)
                                        <option value="{{$productStock->id}}">{{$productStock->batch_no}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="row">
                                    <small id="select_stock" class="text-danger" class="col-md-4"
                                        style="display: none">You must select a stock</small>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="price" class="col-sm-2 col-form-label">Price</label>
                            <div class="col-sm-4">
                                <div class="row">
                                    <input id="price" type="text" class="form-control readonly text-right" name="price"
                                        tabindex="-1" value="" readonly>
                                </div>
                            </div>

                            <div class="col-sm-2">
                                <input id="uom" type="text" class="form-control readonly text-right" name="uom"
                                    tabindex="-1" value="" readonly>
                            </div>

                        </div>

                        <div class="row">
                            <label for="quantity" class="col-sm-2 col-form-label">Quantity</label>
                            <div class="col-sm-4">
                                <div class="row">
                                    <input id="quantity" type="number" name="quantity" pattern="\d+">
                                </div>
                                <div class="row">
                                    <small id="quantity_zero" class="text-danger" class="col-md-4"
                                        style="display: none">Quantity must be filled out</small>
                                    <small id="quantity_min" class="text-danger" class="col-md-4"
                                        style="display: none">Quantity should be greater than 0</small>
                                </div>

                            </div>
                            <div class="col-sm-4">
                                <div class="row">
                                    <button type="button" id="add_product" class="btn btn-primary">Add</button>
                                </div>
                                <div class="row">
                                    <small id="add_product_error" class="text-danger" class="col-md-4"
                                        style="display: none">You should add at least a one product.</small>
                                </div>
                            </div>

                        </div>

                        <div class="form-group row">
                            <div class="align-items-lg-baseline col-sm-6 d-flex justify-content-end">
                                <h4 class="mr-3">Total</h4>
                                <h1 id="product_total_val">0.00</h1>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="lab_payment_card" class="col-sm-2 col-form-label">Payment method</label>
                            <div class="form-check col-sm-2 ml-3">
                                <input class="form-check-input" type="radio" name="payment_method" id="lab_payment_card"
                                    value="card">
                                <label class="form-check-label" for="payment_card">
                                    Credit Card
                                </label>
                            </div>
                            <div class="form-check col-sm-2">
                                <input class="form-check-input" type="radio" name="payment_method" id="lab_payment_cash"
                                    value="cash" checked>
                                <label class="form-check-label" for="payment_cash">
                                    Cash
                                </label>
                            </div>
                        </div>
                        <input type="hidden" id="product_total" name="total">

                        <div class="form-group row d-flex justify-content-end">

                            <button type="btn" id="pharmacy_cancel_btn" class="btn btn-secondary mr-3">Cancel</button>
                            <button type="submit" class="btn btn-primary" id="product_paid_btn">Pay</button>
                            <input type="hidden" id="name" name="name[]">

                        </div>
                    </form>

                    <table id="productTable" class="table table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Item description</th>
                                <th>Quantity</th>
                                <th>Amount (LKR)</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <!-- end pharmacy invoice section -->


                <!-- other invoice section -->
                <div class="tab-pane fade" id="other_tab" role="tabpanel" aria-labelledby="pills-other-tab">
                    <form action="{{route('patients.show', ['patient' => 'xx'])}}" method="POST"
                        id="other_patient_form">
                        @csrf
                        <div class="input-group mb-3 col-sm-6 ml-0 pl-0">
                            <input type="text" class="form-control" placeholder="Patient Number" id="other_number"
                                name="number">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="submit"
                                    id="other_number_search_btn_active">Search</button>
                                <button class="btn btn-outline-secondary" type="button"
                                    id="other_number_search_btn_inactive" style="display: none;" disabled>
                                    <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                                    Serching...
                                </button>
                                <button type="button" class="btn btn-outline-danger" id="other_clear_info_btn"
                                    style="display: none;" data-toggle="tooltip" data-placement="top"
                                    title="Clear selected user information">Clear</button>
                            </div>
                        </div>
                    </form>

                    <hr>

                    <form action="{{route('invoices.other.store')}}" method="POST" id="other_invoice_form">
                        @csrf
                        <input type="hidden" id="other_patient_id" name="patient_id">

                        <div class="form-group row">
                            <label for="other_title" class="col-sm-2 col-form-label">Name</label>
                            <div class="col-sm-2">
                                <select class="form-control" id="other_title" name="title" autofocus>
                                    <option value="Mr" selected>Mr</option>
                                    <option value="Miss">Miss</option>
                                    <option value="Mrs">Mrs</option>
                                    <option value="Dr">Dr</option>
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="other_first_name" name="first_name"
                                    placeholder="First name">
                            </div>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="other_last_name" name="last_name"
                                    placeholder="Last name">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="other_contact" class="col-sm-2 col-form-label">Contact</label>
                            <div class="col-sm-4">
                                <input id="other_contact" type="text" class="form-control" name="contact" required>
                            </div>
                            <label for="other_age" class="col-sm-1 col-form-label">Age</label>
                            <div class="col-sm-2">
                                <input id="other_age" type="text" class="form-control text-right" name="age" required>
                            </div>
                            <label for="other_gender" class="col-sm-1 col-form-label">Gender</label>
                            <div class="col-sm-2">
                                <select class="form-control" id="other_gender" name="gender">
                                    <option value="M" selected>Male</option>
                                    <option value="F">Female</option>
                                    <option value="O">Other</option>
                                </select>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row">
                            <label for="other_service" class="col-sm-2 col-form-label">Services</label>
                            <div class="col-sm-6">
                                <select class="form-control" id="other_service" name="services[]" multiple="multiple"
                                    style="width: 100%">
                                    @foreach ($otherServices as $service)
                                    <option value="{{$service->id}}" data-fee="{{$service->fee}}" @if ($loop->first)
                                        selected @endif>{{$service->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <input type="hidden" id="other_service_fee" name="service_fee">
                        </div>
                        <div class="form-group row">
                            <label for="other_hospital_fee" class="col-sm-2 col-form-label">Hospital Fee</label>
                            <div class="col-sm-4">
                                <input id="other_hospital_fee" type="text" class="form-control readonly text-right"
                                    name="hospital_fee" tabindex="-1"
                                    value="{{$hospital->hospitalFee()->where('invoice_type_id', 4)->first()->fee}}"
                                    readonly>
                            </div>
                            <div class="align-items-lg-baseline col-sm-6 d-flex justify-content-end">
                                <h4 class="mr-3">Total</h4>
                                <h1 id="other_total_val">LKR 1500.00</h1>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="other_payment_card" class="col-sm-2 col-form-label">Payment method</label>
                            <div class="form-check col-sm-2 ml-3">
                                <input class="form-check-input" type="radio" name="payment_method"
                                    id="other_payment_card" value="card">
                                <label class="form-check-label" for="payment_card">
                                    Credit Card
                                </label>
                            </div>
                            <div class="form-check col-sm-2">
                                <input class="form-check-input" type="radio" name="payment_method"
                                    id="other_payment_cash" value="cash" checked>
                                <label class="form-check-label" for="payment_cash">
                                    Cash
                                </label>
                            </div>
                        </div>
                        <input type="hidden" id="other_total" name="total">

                        <div class="form-group row d-flex justify-content-end">
                            <button type="btn" id="other_cancel_btn" class="btn btn-secondary mr-3">Cancel</button>
                            <button type="submit" class="btn btn-primary" id="other_paid_btn">Pay</button>
                        </div>
                    </form>
                </div>
                <!-- end other invoice section -->


            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script src="https://unpkg.com/imask"></script>
<script src="{{asset('js/invoices/opd.js')}}"></script>
<script src="{{asset('js/invoices/lab.js')}}"></script>
<script src="{{asset('js/invoices/channeling.js')}}"></script>
<script src="{{asset('js/invoices/other.js')}}"></script>
<script src="{{asset('js/invoices/product.js')}}"></script>
<script>
    var productStocks = @json($productStocks);
  var products = @json($products);
</script>
<script type="text/javascript">
    var sessionListUrl = "{{route('doctors.sessions', ['doctor'=> 'xx'])}}";
var total = 0;
var transactions = [];
var price = [];
var quantities = [];
var product_name = [];
var invoice = [];
// window.onbeforeunload = function() {
//     return "Hey, are you sure you want to leave?";
// }

$(document).ready(function() {

    // setname();
    window.dataTable = $('#productTable').DataTable({
        "aaSorting" : []
    } );

});

jQuery.extend(jQuery.expr[':'], {
    focusable: function(el, index, selector) {
        return $(el).is('a, button, :input, [tabindex]');
    }
});

$('#productTable').on('click', '#delete', function() {

    var pageParamTable = $('#productTable').DataTable();
    var tableRow = pageParamTable.row($(this).parents('tr'));

    // var count = 0;
    // var ind = 0;
    // for (var k = 0; k < invoice.length; k++) {
    //     if(count == pageParamTable.row(tableRow).index()){
    //         if ( invoice[k] !== {} ) {
    //             console.log("k",invoice[k]);
    //             var dltdprice = invoice[k].price;
    //             invoice[k] = {};
    //             ind = k;
    //             break;
    //         }
    //     }else{
            
    //         if ( invoice[k] !== {} ) {
    //             count++;
    //         }
    //         // var dltdprice = invoice[pageParamTable.row(tableRow).index()].price;
            
    //     }
    // }

    var dltdprice = invoice[pageParamTable.row(tableRow).index()].price;
    invoice.splice(pageParamTable.row(tableRow).index(),1);
    console.log(pageParamTable.row(tableRow).index());
    console.log(invoice);
    

    // invoice[pageParamTable.row(tableRow).index()] = {};
    pageParamTable.row(tableRow).remove().draw();

    reducePrice(dltdprice);

    if(!invoice.length || !invoice.filter(function(name){return Object.keys(name).length;}).length){
        invoice = [];
        $('#name').val([]);
        // console.log("empty invoice");
    }else{ 
        // console.log("invoice");
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


$('#product').change(function() {
    var products = @json($products);
    var productStocks = @json($productStocks);
    $('#uom').val();

    var item = products.find(item => item.id == $(this).val());

    var mesurement;
    if (item.uom == 'U') {
        mesurement = "Per Unit";
    } else if (item.uom == 'B') {
        mesurement = "Per Box";
    } else if (item.uom == 'C') {
        mesurement = "Per Card";
    } else if (item.uom == 'K') {
        mesurement = "Per Kg";
    }else if (item.uom == 'D') {
        mesurement = "Per Bottle";
    }

    $('#uom').attr('value', mesurement);
    jsonObj = [];
    for (var k = 0; k < productStocks.length; k++) {
        if (productStocks[k].product_id == $(this).val()) {
            jsonObj.push(productStocks[k]);
        }
    }
   
    $('#product_stock').empty();
    $("#select_stock").hide();
    $('#quantity').val(null);
    $('#quantity_zero').hide();
    $('#quantity_min').hide();
    
    if(jsonObj.length != 0){
    $.each(jsonObj, function(i, p) {

        $('#product_stock').append($('<option></option>').val(p.id).html(p.batch_no));

    });
    
    }else{
        $('#price').val(null);
        
        
    }

    changePrice();
});

$('#product_stock').change(function() {
    $('#quantity').val(null);
    $('#quantity_zero').hide();
    $('#quantity_min').hide();
    var productStocks = @json($productStocks);
    var products = @json($products);
    var item = productStocks.find(item => item.id == $(this).val());
    var pitem = products.find(pitem => pitem.id == item.product_id);
    // var mesurement;
    if (pitem.uom == 'U') {
        mesurement = "Per Unit";
    } else if (pitem.uom == 'B') {
        mesurement = "Per Box";
    } else if (pitem.uom == 'C') {
        mesurement = "Per Card";
    } else if (pitem.uom == 'K') {
        mesurement = "Per Kg";
    }else if (pitem.uom == 'D') {
        mesurement = "Per Bottle";
    }

    $('#uom').attr('value', mesurement);

    productItem = [];
    productItem.push(pitem);
    $('#product').empty();
    $('#product').append($('<option></option>').val(pitem.id).html(pitem.name));

    jsonObj = [];
    
    for (var k = 0; k < productStocks.length; k++) {
        if (productStocks[k].id == $(this).val()) {
            jsonObj.push(productStocks[k]);
            $('#price').val(productStocks[k].sell_price);
        }
    }
});

function reducePrice(price) {
   
    total = total - price;
    if(isNaN(total)){
        total = 0.00;
        invoice = [];
        $('#name').val([]);
        // console.log("invoice A");
    }else{
        // console.log("invoice B");
        $('#name').val(JSON.stringify(invoice));
    }
    final = (total).toFixed(2);
    var formattedTotal = final.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    $('#product_total_val').html(formattedTotal);
    $('#product_total').val(final);
}


function changePrice() {

    var productStocks = @json($productStocks);
    jsonObj = [];
    for (var k = 0; k < productStocks.length; k++) {
        if (productStocks[k].id == $('#product_stock').val()) {
            jsonObj.push(productStocks[k]);
            $('#price').val(productStocks[k].sell_price);
        }
    }
}



function setname() {

    var products = @json($products);
    var productStocks = @json($productStocks);
    $('#uom').val();

    var item = products.find(item => item.id == $('#product').val());

    var mesurement;
    if (item.uom == 'U') {
        mesurement = "Per Unit";
    } else if (item.uom == 'B') {
        mesurement = "Per Box";
    } else if (item.uom == 'C') {
        mesurement = "Per Card";
    } else if (item.uom == 'K') {
        mesurement = "Per Kg";
    }else if (item.uom == 'D') {
        mesurement = "Per Bottle";
    }

    $('#uom').attr('value', mesurement);

}

function deleteproduct(arrayId) {
    // invoice.remove(arrayId);
    // invoice.splice(arrayId, 1);
    if(!invoice.length || !invoice.filter(function(name){return Object.keys(a).length;}).length){
        invoice = [];
        // console.log("invoice set empty  :".invoice)
    }else{
        invoice[arrayId] = {};
        // console.log("invoice object set empty  :".invoice)
    }
    
}
</script>
@endpush

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .tab-pane {
        background-color: white;
        padding: 16px;
    }

    .nav-pills .nav-link.active,
    .nav-tabs .nav-item.show .nav-link {
        color: #fff;
        background-color: #1ca0f4;
        border-color: #1ca0f4;
        font-size: 18px;
    }

    .nav-pills .nav-link,
    .nav-tabs .nav-item.show .nav-link {
        color: #595959;
        border-color: #D9D9D9;
        font-size: 16px;
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