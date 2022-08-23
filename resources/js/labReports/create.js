$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var feeMask = IMask(
        document.getElementById('fee'), {
        mask: Number,
        scale: 2,
        signed: false,
        thousandsSeparator: '',
        radix: '.',
        padFractionalZeros: true,
        min: 0,
        max: 1000000
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

var reportFormValidator = $("#report_form").validate({
    // debug: true,
    submitHandler: function () {
        store();
    },
    rules: {
        name: {
            required: true,
            maxlength: 250,
        },
        acronym: {
            required: true,
            maxlength: 250,
        },
        fee: {
            required: true,
            number: true,
        },
    },
});

function store() {
    let form = $("#report_form");

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
                        title: 'Created!',
                        text: response.msg,
                        icon: 'success',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                    }
                ).then((result) => {
                    if (result.value) {
                        table.ajax.reload();
                        $('#new_report_model').modal('toggle');
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

$('#new_report_save_btn').click(function (e) {
    e.preventDefault();
    $("#report_form").submit();
});

$('#new_report_model').on('hidden.bs.modal', function (e) {
    initForm();
});

function initForm() {
    $('#report_form').trigger("reset");
    reportFormValidator.resetForm();
    $('#test_datas').trigger('change.select2');
}

function toggleSaveButton(show=true) {
    $('#new_report_save_btn').attr('disabled', show);
}