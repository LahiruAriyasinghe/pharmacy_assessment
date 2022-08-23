$(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip();

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

var ReverseInvoiceFormValidator = $("#reverse_invoice_form").validate({
    // debug: true,
    submitHandler: function () {
        store();
    },
    rules: {
        invoice_id: {
            required: true,
            minlength: 15,
            maxlength: 15,
        },
        admin_username: {
            required: true,
        },
        admin_password: {
            required: true,
        },
    },
});

function store() {
    let form = $("#reverse_invoice_form");

    console.log('object :>> ', form.serialize());
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
                text: response.msg,
            });
            return;
        },
        error: function (request, status, error) {
            console.error("error :>> ", request.responseText);
            toggleSaveButton(false);

            let msg = request.responseJSON.message;

            if ('invoice_id' in request.responseJSON.errors) {
                msg = request.responseJSON.errors.invoice_id[0];
            }
            if ('admin_password' in request.responseJSON.errors) {
                msg = request.responseJSON.errors.admin_password[0];
            }

            // something went wrong
            Swal.fire({
                icon: 'question',
                title: 'Oops!',
                text: msg,
            });
            return;
        },
    });
}


$('#invoice_reverse_save_btn').click(function (e) {
    e.preventDefault();
    $("#reverse_invoice_form").submit();
});

function initForm() {
    ReverseInvoiceFormValidator.resetForm();
    $('#reverse_invoice_form').trigger("reset");
}

function toggleSaveButton(show = true) {
    $('#invoice_reverse_save_btn').attr('disabled', show);
}