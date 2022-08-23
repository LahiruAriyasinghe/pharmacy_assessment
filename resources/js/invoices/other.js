var contactMask, ageMask, hospitalFeeMask, patientNumberMask = null;

$(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip();

    $('#other_service').select2({
        maximumSelectionLength: 5
    });

    contactMask = IMask(
        document.getElementById('other_contact'), {
        mask: '000 000 0000'
    });

    ageMask = IMask(
        document.getElementById('other_age'), {
        mask: Number,
        scale: 0,
        signed: false,
        min: 0,
        max: 150
    });

    hospitalFeeMask = IMask(
        document.getElementById('other_hospital_fee'), {
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
        document.getElementById('other_number'), {
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

var otherInvoiceFormValidator = $("#other_invoice_form").validate({
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
        service: {
            required: true,
        },
        drug_fee: {
            required: false,
        },
    },
});

function calculateTotal() {
    let serviceFee = 0;
    let hospitalFee = $('#other_hospital_fee').val();

    $('#other_service').children("option:selected").each(function (element) {
        serviceFee += parseFloat($(this).data('fee'));
    });

    let total = (serviceFee + parseFloat(hospitalFee ? hospitalFee : 0)).toFixed(2);

    let formattedTotal = total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

    $('#other_total_val').html(formattedTotal);
    $('#other_total').val(total);
}

function store() {
    let form = $("#other_invoice_form");

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

$('#other_service').change(function (e) {
    calculateTotal();
});


function initForm() {
    otherInvoiceFormValidator.resetForm();
    $('#other_patient_form').trigger("reset");
    $('#other_invoice_form').trigger("reset");
    $('#other_number_search_btn_inactive').hide();
    $('#other_number_search_btn_active').show();
    $('#other_service_fee').val($('#other_service').children("option:selected").data('fee'));
    $('#other_service').val(1).trigger('change.select2');
    clearPatientDetails();
    calculateTotal();
}

$("#other_patient_form").validate({
    // debug: true,
    submitHandler: function () {
        getPatient();
    },
    rules: {
        number: {
            // required: true,
            minlength: 10,
            maxlength: 10,
            number: true,
        },
    },
});

function getPatient() {

    let id = $('#other_number').val();
    let form = $("#other_patient_form");
    let url = form.attr("action").replace("xx", id);

    if (id.trim() == '') {
        return;
    }

    $('#other_number_search_btn_active').hide();
    $('#other_number_search_btn_inactive').show();

    $.ajax({
        type: "GET",
        url: url,
        data: null,
        success: function (response) {
            console.log('getPatient :>> ', response);
            $('#other_number_search_btn_inactive').hide();
            $('#other_number_search_btn_active').show();
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
            $('#other_number_search_btn_inactive').hide();
            $('#other_number_search_btn_active').show();

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
    $('#other_patient_id').val(patient.id);
    $('#other_title').val(patient.title);
    $('#other_first_name').val(patient.first_name);
    $('#other_last_name').val(patient.last_name);
    $('#other_contact').val(patient.contact);
    $('#other_age').val(patient.age);
    $('#other_gender').val(patient.gender);

    $('#other_clear_info_btn').show();

    $("#other_service").focus();
}

$('#other_clear_info_btn').click(function (e) {
    e.preventDefault();
    clearPatientDetails();
});

function clearPatientDetails() {
    $('#other_patient_id').val('');
    $('#other_title').val('Mr');
    $('#other_first_name').val('');
    $('#other_last_name').val('');
    $('#other_contact').val('');
    $('#other_age').val('');
    $('#other_gender').val('M');

    contactMask.value = '';
    ageMask.value = '';    
    patientNumberMask.value = '';

    $('#other_clear_info_btn').hide();

    $('#other_number').focus();
}

$('#other_cancel_btn').click(function (e) { 
    e.preventDefault();
    initForm();
});

$('#other_number').keyup(function (e) {
    if (e.keyCode == 13) {
        $('#other_patient_form').submit();
    }
});

function togglePaidButton(show=true) {
    $('#other_paid_btn').attr('disabled', show);
}