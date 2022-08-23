$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        }
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

var unitFormValidator = $("#units_form").validate({
    // debug: true,
    submitHandler: function () {
        store();
    },
    rules: {
        unit: {
            required: true,
            maxlength: 250,
        },
        name: {
            required: false,
            maxlength: 250,
        },
    },
});

function store() {
    let form = $("#units_form");

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
                        $('#new_unit_model').modal('toggle');
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

$('#new_unit_save_btn').click(function (e) {
    e.preventDefault();
    $("#units_form").submit();
});

$('#new_unit_model').on('hidden.bs.modal', function (e) {
    initForm();
});

function initForm() {
    $('#units_form').trigger("reset");
    unitFormValidator.resetForm();
}

function toggleSaveButton(show = true) {
    $('#new_unit_save_btn').attr('disabled', show);
}