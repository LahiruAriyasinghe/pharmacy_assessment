var contactMask, ageMask, hospitalFeeMask, patientNumberMask = null;

$(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip();

    contactMask = IMask(
        document.getElementById('chnl_contact'), {
        mask: '000 000 0000'
    });

    ageMask = IMask(
        document.getElementById('chnl_age'), {
        mask: Number,
        scale: 0,
        signed: false,
        min: 0,
        max: 150
    });

    hospitalFeeMask = IMask(
        document.getElementById('chnl_hospital_fee'), {
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
        document.getElementById('chnl_number'), {
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

var chnlInvoiceFormValidator = $("#chnl_invoice_form").validate({
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
        session: {
            required: true,
        },
        drug_fee: {
            required: false,
        },
    },
});

function calculateTotal() {
    let doctorFee = $('#chnl_doctor_fee').val();
    let hospitalFee = $('#chnl_hospital_fee').val();
    let drugFee = $('#chnl_drug_fee').val();

    let total = (parseFloat(doctorFee ? doctorFee : 0) + parseFloat(hospitalFee ? hospitalFee : 0) + parseFloat(drugFee ? drugFee : 0)).toFixed(2);

    let formattedTotal = total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

    $('#chnl_total_val').html(formattedTotal);
    $('#chnl_total').val(total);
}

function store() {
    let form = $("#chnl_invoice_form");
    
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
                    title: 'Token ' + response.data.token,
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

$('#chnl_doctor').change(function (e) {
    $('#chnl_doctor_fee').val($(this).children("option:selected").data('fee'));
    calculateTotal();
});

$('#chnl_drug_fee').keyup(function (e) {
    calculateTotal();
});

function initForm() {
    chnlInvoiceFormValidator.resetForm();
    $('#chnl_patient_form').trigger("reset");
    $('#chnl_invoice_form').trigger("reset");
    $('#chnl_number_search_btn_inactive').hide();
    $('#chnl_number_search_btn_active').show();
    $('#chnl_doctor_fee').val($('#chnl_doctor').children("option:selected").data('fee'));
    clearPatientDetails();
    calculateTotal();
    getSessions();
}

$("#chnl_patient_form").validate({
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

    let id = $('#chnl_number').val();
    let form = $("#chnl_patient_form");
    let url = form.attr("action").replace("xx", id);

    if (id.trim() == '') {
        return;
    }

    $('#chnl_number_search_btn_active').hide();
    $('#chnl_number_search_btn_inactive').show();

    $.ajax({
        type: "GET",
        url: url,
        data: null,
        success: function (response) {
            console.log('getPatient :>> ', response);
            $('#chnl_number_search_btn_inactive').hide();
            $('#chnl_number_search_btn_active').show();
            if ("success" in response) {
                updatePatientDetails(response.data.patient);
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
            $('#chnl_number_search_btn_inactive').hide();
            $('#chnl_number_search_btn_active').show();

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

$('#chnl_doctor').change(function (e) {
    e.preventDefault();
    getSessions();
});

function getSessions() {

    let doctorId = $('#chnl_doctor').val();
    let url = sessionListUrl.replace("xx", doctorId);

    $.ajax({
        type: "GET",
        url: url,
        data: null,
        success: function (response) {
            console.log('getSessions :>> ', response);

            if ("success" in response) {
                let sessions = response.data.sessions;
                let $select = $('#chnl_session');
                let option, badge = null;

                if (sessions.length == 0) {
                    $('#chnl_session_help').html('Note: Selected doctor doesn\'t assign with any session.').show();
                }else{
                    $('#chnl_session_help').hide();
                }

                $select.empty();

                sessions.forEach(session => {
                    badge = (session.maximum_patients <= session.channels_count) ? `| ** max user limit exceeds **` : '';
                    option = `<option value="${session.id}">${session.name} - ${session.week_day} | ${session.start_at} ${badge}</option>`;
                    $select.append(option);
                    option = null;
                });

                return;
            }

            // something went wrong
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Something went wrong!',
            });
            return;
        },
        error: function (request, status, error) {
            console.error("error :>> ", request.responseText);

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

function updatePatientDetails(patient) {
    $('#chnl_patient_id').val(patient.id);
    $('#chnl_title').val(patient.title);
    $('#chnl_first_name').val(patient.first_name);
    $('#chnl_last_name').val(patient.last_name);
    $('#chnl_contact').val(patient.contact);
    $('#chnl_age').val(patient.age);
    $('#chnl_gender').val(patient.gender);

    $('#chnl_clear_info_btn').show();

    $("#chnl_doctor").focus();
}

$('#chnl_clear_info_btn').click(function (e) {
    e.preventDefault();
    clearPatientDetails();
});

function clearPatientDetails() {
    $('#chnl_patient_id').val('');
    $('#chnl_title').val('Mr');
    $('#chnl_first_name').val('');
    $('#chnl_last_name').val('');
    $('#chnl_contact').val('');
    $('#chnl_age').val('');
    $('#chnl_gender').val('M');

    contactMask.value = '';
    ageMask.value = '';
    patientNumberMask.value = '';

    $('#chnl_clear_info_btn').hide();

    $('#chnl_number').focus();
}

$('#chnl_cancel_btn').click(function (e) {
    e.preventDefault();
    initForm();
});

$('#chnl_number').keyup(function (e) {
    if (e.keyCode == 13) {
        $('#chnl_patient_form').submit();
    }
});

function togglePaidButton(show=true) {
    $('#chnl_paid_btn').attr('disabled', show);
}