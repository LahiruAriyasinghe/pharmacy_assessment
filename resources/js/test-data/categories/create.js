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

var categoriesFormValidator = $("#categories_form").validate({
    // debug: true,
    submitHandler: function () {
        store();
    },
    rules: {
        name: {
            required: true,
            maxlength: 250,
        },
    },
});

function store() {
    let form = $("#categories_form");

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
                        $('#new_category_model').modal('toggle');
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

$('#new_category_save_btn').click(function (e) {
    e.preventDefault();
    $("#categories_form").submit();
});

$('#new_category_model').on('hidden.bs.modal', function (e) {
    initForm();
});

function initForm() {
    $('#categories_form').trigger("reset");
    categoriesFormValidator.resetForm();
}

function toggleSaveButton(show = true) {
    $('#new_category_save_btn').attr('disabled', show);
}