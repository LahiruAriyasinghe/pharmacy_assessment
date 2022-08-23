var contactMask, ageMask, hospitalFeeMask, patientNumberMask = null;

$(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip();

    $('#lab_report').select2({
        maximumSelectionLength: 5
    });

    contactMask = IMask(
        document.getElementById('lab_contact'), {
        mask: '000 000 0000'
    });

    ageMask = IMask(
        document.getElementById('lab_age'), {
        mask: Number,
        scale: 0,
        signed: false,
        min: 0,
        max: 150
    });

    hospitalFeeMask = IMask(
        document.getElementById('lab_hospital_fee'), {
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
        document.getElementById('lab_number'), {
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

var labInvoiceFormValidator = $("#lab_invoice_form").validate({
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
        report: {
            required: true,
        },
        drug_fee: {
            required: false,
        },
    },
});

function calculateTotal() {
    let reportFee = 0;
    let hospitalFee = $('#lab_hospital_fee').val();

    $('#lab_report').children("option:selected").each(function (element) {
        reportFee += parseFloat($(this).data('fee'));
    });

    let total = (reportFee + parseFloat(hospitalFee ? hospitalFee : 0)).toFixed(2);

    let formattedTotal =  total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

    $('#lab_total_val').html(formattedTotal);
    $('#lab_total').val(total);
}

function store() {
    let form = $("#lab_invoice_form");

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

$('#lab_report').change(function (e) {
    calculateTotal();
});

function initForm() {
    labInvoiceFormValidator.resetForm();
    $('#lab_patient_form').trigger("reset");
    $('#lab_invoice_form').trigger("reset");
    $('#lab_number_search_btn_inactive').hide();
    $('#lab_number_search_btn_active').show();
    $('#lab_report_fee').val($('#lab_report').children("option:selected").data('fee'));
    $('#lab_report').val(1).trigger('change.select2');
    clearPatientDetails();
    calculateTotal();
}

$("#lab_patient_form").validate({
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
    
    let id = $('#lab_number').val();
    let form = $("#lab_patient_form");
    let url = form.attr("action").replace("xx", id);

    if (id.trim() == '') {
        return;
    }

    $('#lab_number_search_btn_active').hide();
    $('#lab_number_search_btn_inactive').show();

    $.ajax({
        type: "GET",
        url: url,
        data: null,
        success: function (response) {
            console.log('getPatient :>> ', response);
            $('#lab_number_search_btn_inactive').hide();
            $('#lab_number_search_btn_active').show();
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
            $('#lab_number_search_btn_inactive').hide();
            $('#lab_number_search_btn_active').show();

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
    $('#lab_patient_id').val(patient.id);
    $('#lab_title').val(patient.title);
    $('#lab_first_name').val(patient.first_name);
    $('#lab_last_name').val(patient.last_name);
    $('#lab_contact').val(patient.contact);
    $('#lab_age').val(patient.age);
    $('#lab_gender').val(patient.gender);

    $('#lab_clear_info_btn').show();

    $("#lab_report").focus();
}

$('#lab_clear_info_btn').click(function (e) { 
    e.preventDefault();
    clearPatientDetails();
});

function clearPatientDetails() {
    $('#lab_patient_id').val('');
    $('#lab_title').val('Mr');
    $('#lab_first_name').val('');
    $('#lab_last_name').val('');
    $('#lab_contact').val('');
    $('#lab_age').val('');
    $('#lab_gender').val('M');

    contactMask.value = '';
    ageMask.value = '';    
    patientNumberMask.value = '';

    $('#lab_clear_info_btn').hide();

    $('#lab_number').focus();
}

$('#lab_cancel_btn').click(function (e) { 
    e.preventDefault();
    initForm();
});

$('#lab_number').keyup(function (e) {
    if (e.keyCode == 13) {
        $('#lab_patient_form').submit();
    }
});

function togglePaidButton(show=true) {
    $('#lab_paid_btn').attr('disabled', show);
}