var IS_COMPLETE = false;

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

var resultFormValidator = $("#lab_results_form").validate({
    // debug: true,
    submitHandler: function () {
        store();
    },
    rules: {

    },
});

function store() {
    let form = $("#lab_results_form");
    let formData = form.serializeArray();
    formData.push({ name: "is_complete", value: (IS_COMPLETE) ? true : false });
    toggleSaveButton(true);

    $.ajax({
        type: "POST",
        url: form.attr("action"),
        data: formData,
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

$('#result_save_btn').click(function (e) {
    e.preventDefault();
    IS_COMPLETE = false;
    $("#lab_results_form").submit();
});

$('#result_complete_btn').click(function (e) {
    e.preventDefault();
    IS_COMPLETE = true;
    $("#lab_results_form").submit();
});

function initForm() {
    $('#lab_results_form').trigger("reset");
    resultFormValidator.resetForm();
}

function toggleSaveButton(show = true) {
    $('#result_save_btn').attr('disabled', show);
    $('#result_complete_btn').attr('disabled', show);
}