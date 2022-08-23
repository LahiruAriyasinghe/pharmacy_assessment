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

specialtyFormValidator = $("#specialties_form").validate({
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
        description: {
            maxlength: 250,
        },
    },
});

function store() {
    let form = $("#specialties_form");

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
                        $('#new_specialty_model').modal('toggle');
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
            console.error("error :>> ", request.responseJSON);
            let msg = error;
            let errors = request.responseJSON.errors;
            for (const key in errors) {
                if (errors.hasOwnProperty(key)) {
                    const element = errors[key];
                    console.log("element :>> ", element[0]);
                    msg = element[0];
                }
            }
            toggleSaveButton(false);
            // something went wrong
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: msg,
            });
            return;
        },
    });
}

$('#new_specialty_save_btn').click(function (e) {
    e.preventDefault();
    $("#specialties_form").submit();
});

$('#new_specialty_model').on('hidden.bs.modal', function (e) {
    initForm();
});

function initForm() {
    $('#specialties_form').trigger("reset");
    specialtyFormValidator.resetForm();
    $('.is-invalid').removeClass('is-invalid');
}

function toggleSaveButton(show=true) {
    $('#new_specialty_save_btn').attr('disabled', show);
}