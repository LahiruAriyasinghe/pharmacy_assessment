var contactMask, ageMask, drugFeeMask, hospitalFeeMask, patientNumberMask = null;

$(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip();

    contactMask = IMask(
        document.getElementById('opd_contact'), {
        mask: '000 000 0000'
    });

    ageMask = IMask(
        document.getElementById('opd_age'), {
        mask: Number,
        scale: 0,
        signed: false,
        min: 0,
        max: 150
    });

    drugFeeMask = IMask(
        document.getElementById('opd_drug_fee'), {
        mask: Number,
        scale: 2,
        signed: false,
        thousandsSeparator: '',
        radix: '.',
        padFractionalZeros: true,
        min: 0,
        max: 1000000
    });

    hospitalFeeMask = IMask(
        document.getElementById('opd_hospital_fee'), {
        mask: Number,
        scale: 2,
        signed: false,
        thousandsSeparator: '',
        radix: '.',
        padFractionalZeros: true,
        min: 0,
        max: 1000000
    });

    patientNumberMask = IMask(
        document.getElementById('opd_number'), {
        mask: Number,
        scale: 0,
        signed: false,
        thousandsSeparator: '',
        radix: '.',
        padFractionalZeros: false,
        min: 0,
        max: 9999999999
    });

    initForm();
});

jQuery.validator.setDefaults({
    errorElement: "div",
    errorPlacement: function (error, element) {
        error.addClass("invalid-feedback");
        element.closest("div").append(error);
    },
    highlight: function (element, errorClass, validClass) {
        $(element).addClass("is-invalid");
    },
    unhighlight: function (element, errorClass, validClass) {
        $(element).removeClass("is-invalid");
    },
});

var opdInvoiceFormValidator = $("#opd_invoice_form").validate({
    // debug: true,
    submitHandler: function () {
        calculateTotal();
        store();
    },
    rules: {
        title: {
            required: true,
        },
        first_name: {
            required: true,
            maxlength: 250,
        },
        last_name: {
            required: false,
            maxlength: 250,
        },
        contact: {
            required: true,
            minlength: 12,
            maxlength: 14,
        },
        age: {
            required: true,
        },
        gender: {
            required: true,
        },
        doctor: {
            required: true,
        },
        drug_fee: {
            required: false,
        },
    },
});

function calculateTotal() {
    let doctorFee = $('#opd_doctor_fee').val();
    let hospitalFee = $('#opd_hospital_fee').val();
    let drugFee = $('#opd_drug_fee').val();

    let total = (parseFloat(doctorFee ? doctorFee : 0) + parseFloat(hospitalFee ? hospitalFee : 0) + parseFloat(drugFee ? drugFee : 0)).toFixed(2);

    let formattedTotal =  total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

    $('#opd_total_val').html(formattedTotal);
    $('#opd_total').val(total);
}

function store() {
    let form = $("#opd_invoice_form");

    console.log('object :>> ', form.serialize());
    togglePaidButton(true);

    $.ajax({
        type: "POST",
        url: form.attr("action"),
        data: form.serialize(),
        success: function (response) {
            console.log(response);
            togglePaidButton(false);

            if ("success" in response) {
                // clear form
                // show message
                Swal.fire({
                    text: "Transaction Completed",
                    icon: 'success',
                    showCancelButton: true,
                    reverseButtons: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Print invoice',
                    cancelButtonText: 'Close'
                  }).then((result) => {
                    if (result.value) {
                        window.open(response.data.invoice_pdf_url);
                    }
                    initForm();
                  })
                return;
            }

            // something went wrong
            // show error msg
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Something went wrong!',
            });
            return;
        },
        error: function (request, status, error) {
            console.error("error :>> ", request.responseText);
            togglePaidButton(false);

            // something went wrong
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Something went wrong!',
            });
            return;
        },
    });
}

$('#opd_doctor').change(function (e) {
    $('#opd_doctor_fee').val($(this).children("option:selected").data('fee'));
    calculateTotal();
});

$('#opd_drug_fee').keyup(function (e) {
    calculateTotal();
});

function initForm() {
    opdInvoiceFormValidator.resetForm();
    clearPatientDetails();

    drugFeeMask.value = '';

    $('#opd_patient_form').trigger("reset");
    $('#opd_invoice_form').trigger("reset");

    $('#opd_number_search_btn_inactive').hide();
    $('#opd_number_search_btn_active').show();

    $('#opd_doctor_fee').val($('#opd_doctor').children("option:selected").data('fee'));
    calculateTotal();
    togglePaidButton(false);
}

$("#opd_patient_form").validate({
    // debug: true,
    submitHandler: function () {
        getPatient();
    },
    rules: {
        number: {
            minlength: 10,
            maxlength: 10,
            number: true,
        },
    },
});

function getPatient() {
    
    let id = $('#opd_number').val();
    let form = $("#opd_patient_form");
    let url = form.attr("action").replace("xx", id);

    if (id.trim() == '') {
        return;
    }

    $('#opd_number_search_btn_active').hide();
    $('#opd_number_search_btn_inactive').show();

    $.ajax({
        type: "GET",
        url: url,
        data: null,
        success: function (response) {
            console.log('getPatient :>> ', response);
            $('#opd_number_search_btn_inactive').hide();
            $('#opd_number_search_btn_active').show();
            if ("success" in response) {
                updatePatientDetails(response.data.patient);
                return;
            }

            Swal.fire({
                icon: 'question',
                title: 'Cannot find the patient',
                text: 'Please recheck the patient number from receipt or create new patient.',
                showConfirmButton: false,
                timer: 2000
              });
            return;
        },
        error: function (request, status, error) {
            console.error("error :>> ", request.responseText);
            $('#opd_number_search_btn_inactive').hide();
            $('#opd_number_search_btn_active').show();

            Swal.fire({
                icon: 'question',
                title: 'Cannot find the patient',
                text: 'Please recheck the patient number from receipt or create new patient.',
                showConfirmButton: false,
                timer: 2000
              });
            return;
        },
    });
}

function updatePatientDetails(patient) {
    $('#opd_patient_id').val(patient.id);
    $('#opd_title').val(patient.title);
    $('#opd_first_name').val(patient.first_name);
    $('#opd_last_name').val(patient.last_name);
    $('#opd_contact').val(patient.contact);
    $('#opd_age').val(patient.age);
    $('#opd_gender').val(patient.gender);

    $('#opd_clear_info_btn').show();

    $("#opd_doctor").focus();
}

$('#opd_clear_info_btn').click(function (e) { 
    e.preventDefault();
    clearPatientDetails();
});

function clearPatientDetails() {
    $('#opd_patient_id').val('');
    $('#opd_title').val('Mr');
    $('#opd_first_name').val('');
    $('#opd_last_name').val('');
    $('#opd_contact').val('');
    $('#opd_age').val('');
    $('#opd_gender').val('M');

    contactMask.value = '';
    ageMask.value = '';    
    patientNumberMask.value = '';

    $('#opd_clear_info_btn').hide();

    $('#opd_number').focus();
}

$('#opd_cancel_btn').click(function (e) { 
    e.preventDefault();
    initForm();
});

$('#opd_number').keyup(function (e) {
    if (e.keyCode == 13) {
        $('#opd_patient_form').submit();
    }
});

function togglePaidButton(show=true) {
    $('#opd_paid_btn').attr('disabled', show);
}