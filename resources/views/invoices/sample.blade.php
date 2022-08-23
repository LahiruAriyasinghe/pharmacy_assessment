<form action="{{route('patients.show', ['patient' => 'xx'])}}" method="POST" id="other_patient_form">
    @csrf
    <div class="input-group mb-3 col-sm-6 ml-0 pl-0">
        <input type="text" class="form-control" placeholder="Patient Number" id="other_number"
            name="number">
        <div class="input-group-append">
            <button class="btn btn-outline-secondary" type="submit"
                id="other_number_search_btn_active">Search</button>
            <button class="btn btn-outline-secondary" type="button" id="other_number_search_btn_inactive"
                style="display: none;" disabled>
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
        <label for="inputEmail3" class="col-sm-2 col-form-label">Name</label>
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
        <label for="contact" class="col-sm-2 col-form-label">Contact</label>
        <div class="col-sm-4">
            <input id="other_contact" type="text" class="form-control" name="contact" required>
        </div>
        <label for="age" class="col-sm-1 col-form-label">Age</label>
        <div class="col-sm-2">
            <input id="other_age" type="text" class="form-control text-right" name="age" required>
        </div>
        <label for="gender" class="col-sm-1 col-form-label">Gender</label>
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
        <label for="doctor" class="col-sm-2 col-form-label">Doctor</label>
        <div class="col-sm-6">
            <select class="form-control" id="other_doctor" name="doctor">
                @foreach ($doctors as $doctor)
                <option value="{{$doctor->id}}" data-fee="{{$doctor->fee}}" @if ($loop->first)
                    selected @endif>{{$doctor->user->first_name}}</option>
                @endforeach
            </select>
        </div>
        <input type="hidden" id="other_doctor_fee" name="doctor_fee">
    </div>
    <div class="form-group row">
        <label for="drug_fee" class="col-sm-2 col-form-label">Drugs Fee</label>
        <div class="col-sm-4">
            <input id="other_drug_fee" type="text" class="form-control text-right" name="drug_fee">
        </div>

    </div>
    <div class="form-group row">
        <label for="hospital_fee" class="col-sm-2 col-form-label">Hospital Fee</label>
        <div class="col-sm-4">
            <input id="other_hospital_fee" type="text" class="form-control readonly text-right"
                name="hospital_fee" tabindex="-1" value="{{$hospital->fee}}" readonly>
        </div>
        <div class="align-items-lg-baseline col-sm-6 d-flex justify-content-end">
            <h4 class="mr-3">Total</h4>
            <h1 id="other_total_val">LKR 1500.00</h1>
        </div>
    </div>
    <div class="form-group row">
        <label for="hospital_fee" class="col-sm-2 col-form-label">Payment method</label>
        <div class="form-check col-sm-2 ml-3">
            <input class="form-check-input" type="radio" name="payment_method" id="other_payment_card"
                value="card">
            <label class="form-check-label" for="payment_card">
                Credit Card
            </label>
        </div>
        <div class="form-check col-sm-2">
            <input class="form-check-input" type="radio" name="payment_method" id="other_payment_cash"
                value="cash" checked>
            <label class="form-check-label" for="payment_cash">
                Cash
            </label>
        </div>
    </div>
    <input type="hidden" id="other_total" name="total">

    <div class="form-group row d-flex justify-content-end">
        <button type="btn" class="btn btn-secondary mr-3">Cancel</button>
        <button type="submit" class="btn btn-primary">Paid</button>
    </div>
</form>