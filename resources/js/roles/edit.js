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

var roleFormValidator = $("#role_form").validate({
    // debug: true,
    submitHandler: function () {
        store();
    },
    rules: {
        role_name: {
            required: true,
        },
        terms: "required"
    },
});

function store() {
    let form = $("#role_form");

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
            let msg = request.responseJSON.message;

            if ('role_permissions' in request.responseJSON.errors) {
                msg = 'Role permission required.';
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

$('#role_save_btn').on('click', function (e) {
    e.preventDefault();
    $("#role_form").trigger("submit");
});

$('#new_role_model').on('hidden.bs.modal', function (e) {
    initForm();
});

$('.permission-category').on('change', function (e) { 
    e.preventDefault();
    let id = $(this).attr('id');

    if($(this).is(":checked")){
        // check all
        $(`.${id}`).prop('checked', true);
    }else{
        // un check all
        $(`.${id}`).prop('checked', false);
    }
});

$('.permission').on('change', function (e) { 
    e.preventDefault();
    let classes = $(this).attr("class");
    let id =  classes.split(" ")[0];
    
    if(!$(this).is(":checked")){
        // un check the check all btn
        // alert(id);
        $(`#${id}`).prop('checked', false);
    }
});

function initForm() {
    $('#role_form').trigger("reset");
    roleFormValidator.resetForm();
}

function toggleSaveButton(show=true) {
    $('#role_save_btn').attr('disabled', show);
}