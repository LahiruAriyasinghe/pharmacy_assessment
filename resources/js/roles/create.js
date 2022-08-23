
$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        }
    });

});

var roleFormValidator = jQuery.validator.setDefaults({
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
        
roleFormValidator = $("#role_form").validate({
    // debug: true,
    submitHandler: function () {
        // alert('sry');
        store();
    },
    rules: {
        role_name: {
            required: true,
        },
        role_permissions: {
            required: true,
        },
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
                        title: 'Created!',
                        text: response.msg,
                        icon: 'success',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                    }
                ).then((result) => {
                    if (result.value) {
                        // table.ajax.reload();
                        // $('#new_role_model').modal('toggle');
                        if (result.value) {
                            window.location.replace(response.next)
                        }
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

$('#new_role_save_btn').on('click', function (e) {
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
    $('#new_role_save_btn').attr('disabled', show);
}