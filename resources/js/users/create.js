var emailCheckUrl = null;

$(function () {
    var contactMask = IMask(
        document.getElementById('contact'), {
        mask: '000 000 0000'
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

    emailCheckUrl = $('#email_check_url').val();
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

$.validator.addMethod("usernameRegex", function (value, element) {
    return this.optional(element) || /^[a-z0-9\-\s]+$/i.test(value);
}, "Username must contain only letters, numbers, or dashes.");

var userFormValidator = $("#user_form").validate({
    // debug: true,
    submitHandler: function () {
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
            maxlength: 250,
        },
        username: {
            required: true,
            usernameRegex: true,
            minlength: 5,
            maxlength: 250,
            remote: {
                url: $('#username_check_url').val(),
                type: "GET",
                data: {
                    username: function () {
                        return $("#username").val();
                    },
                    hospital: function () {
                        return $("#hospital_id").val();
                    },
                }
            }
        },
        email: {
            required: false,
            email: true,
            maxlength: 250,
            remote: {
                url: $('#email_check_url').val(),
            },
        },
        contact: {
            required: true,
            minlength: 10,
            maxlength: 14,
        },
        gender: {
            required: true,
        },
        specialty: {
            required: function (element) {
                return $("#is_doctor").prop("checked") == true;
            }
        },
        note: {
            required: false,
            minlength: 5,
            maxlength: 500,
        },
        fee: {
            required: function (element) {
                return $("#is_doctor").prop("checked") == true;
            },
            number: true,
        },
    },
    messages: {        
        username: {
            remote: "Given username already exists",
        },
        email: {
            remote: "Given email already exists",
        },
        
    },
});

function store() {
    let form = $("#user_form");

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
                        $('#new_user_model').modal('toggle');
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

$('#new_user_save_btn').click(function (e) {
    e.preventDefault();
    $("#user_form").submit();
});

$('#is_doctor').change(function (e) {
    e.preventDefault();
    showDoctor();
});

$('#new_user_model').on('shown.bs.modal', function (e) {
    userFormValidator.resetForm();
    showDoctor();
});

$('#new_user_model').on('hidden.bs.modal', function (e) {
    initForm();
});

function showDoctor() {
    if ($('#is_doctor').prop("checked") == true) {
        $('.when-doctor').show();
    } else {
        $('.when-doctor').hide();
    }
}

function initForm() {
    $('#user_form').trigger("reset");
    userFormValidator.resetForm();
    showDoctor();
}

function toggleSaveButton(show=true) {
    $('#new_user_save_btn').attr('disabled', show);
}