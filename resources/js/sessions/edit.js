var patientMask = null;

$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        }
    });

    patientMask = IMask(
        document.getElementById('maximum_patients'),
        {
            mask: Number,
            min: 0,
            max: 1000,
            thousandsSeparator: ''
        });
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

$.validator.addMethod('dateBefore', function (value, element, params) {
    // if end date is valid, validate it as well
    var end = $(params);
    if (!end.data('validation.running')) {
        $(element).data('validation.running', true);
        // The validator internally keeps track of which element is being validated currently.  This ensures that validating 'end' will not trample 'start'
        // see http://stackoverflow.com/questions/22107742/jquery-validation-date-range-issue
        setTimeout($.proxy(

            function () {
                this.element(end);
            }, this), 0);
        // Ensure clearing the 'flag' happens after the validation of 'end' to prevent endless looping
        setTimeout(function () {
            $(element).data('validation.running', false);
        }, 0);
    }
    return this.optional(element) || this.optional(end[0]) || (value) < (end.val());

}, 'Must be before end time.');

$.validator.addMethod('dateAfter', function (value, element, params) {
    // if start date is valid, validate it as well
    var start = $(params);
    if (!start.data('validation.running')) {
        $(element).data('validation.running', true);
        setTimeout($.proxy(

            function () {
                this.element(start);
            }, this), 0);
        setTimeout(function () {
            $(element).data('validation.running', false);
        }, 0);
    }
    return this.optional(element) || this.optional(start[0]) || (value) > ($(params).val());

}, 'Must be after start time.');

var sessionFormValidator = $("#session_form").validate({
    // debug: true,
    submitHandler: function () {
        store();
    },
    rules: {
        name: {
            required: true,
            maxlength: 250,
        },
        room_no: {
            required: true,
            maxlength: 250,
        },
        doctor_id: {
            required: true,
        },
        nurse_id: {
            required: false,
        },
        week_day: {
            required: true,
        },
        start_at: {
            required: true,
            dateBefore: '#end_at',
        },
        end_at: {
            required: true,
            dateAfter: '#start_at',
        },
        maximum_patients: {
            required: true,
            number: true,
        },
    },
});

function store() {
    let form = $("#session_form");

    toggleSaveButton(true);

    $.ajax({
        type: "POST",
        url: form.attr("action"),
        data: form.serialize(),
        success: function (response) {
            console.log(response);
            toggleSaveButton(false);

            if ("success" in response) {
                // clear form
                // show message
                Swal.fire(
                    {
                        title: 'Updated!',
                        text: response.msg,
                        icon: 'success',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                    }
                ).then((result) => {
                    if (result.value) {
                        window.location.replace(response.next)
                    }
                });
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
            toggleSaveButton(false);

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

$('#new_session_save_btn').click(function (e) {
    e.preventDefault();
    $("#session_form").submit();
});

$('#new_session_model').on('hidden.bs.modal', function (e) {
    initForm();
});

function initForm() {
    $('#session_form').trigger("reset");
    sessionFormValidator.resetForm();

    patientMask.destroy();
    patientMask = IMask(
        document.getElementById('maximum_patients'),
        {
            mask: Number,
            min: 0,
            max: 1000,
            thousandsSeparator: ''
        });
}

function toggleSaveButton(show = true) {
    $('#new_session_save_btn').attr('disabled', show);
}