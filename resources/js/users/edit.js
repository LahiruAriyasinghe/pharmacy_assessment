var emailCheckUrl = null;

$(function () {
    $('.when-doctor').hide();

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

    showDoctor();
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

$.validator.addMethod("usernameRegex", function(value, element) {
    return this.optional(element) || /^[a-z0-9\-\s]+$/i.test(value);
}, "Username must contain only letters, numbers, or dashes.");


$("#user_form").validate({
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
                    username: function() {
                    return $( "#username" ).val();
                  },
                  hospital: function() {
                    return $( "#hospital_id" ).val();
                  },
                  user_id: function() {
                    return $( "#user_id" ).val();
                  },
                }
              }
        },
        email: {
            required: false,
            email:true,
            maxlength: 250,
            remote: {
                url: $('#email_check_url').val(),
                type: "GET",
                data: {
                  email: function() {
                    return $( "#email" ).val();
                  },
                  user_id: function() {
                    return $( "#user_id" ).val();
                  },
                }
              }
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

            Swal.fire({
                icon: 'question',
                title: 'Cannot find the patient',
                text: 'Please recheck the patient number from receipt or create new patient.',
                showConfirmButton: false,
                timer: 2000
              });
            return;
        },
        error: function (request, status, error) {
            console.error("error :>> ", request.responseText);
            toggleSaveButton(false);
            
            Swal.fire({
                icon: 'question',
                title: 'Cannot find the patient',
                text: 'Please recheck the patient number from receipt or create new patient.',
                showConfirmButton: false,
                timer: 2000
              });
            return;
        },
    });
}

$('#is_doctor').change(function (e) { 
    e.preventDefault();
    showDoctor();
});


function showDoctor() {
    if ($('#is_doctor').prop("checked") == true) {
        $('.when-doctor').show();
    } else {
        $('.when-doctor').hide();
    }
}

function toggleSaveButton(show=true) {
    $('#user_save_btn').attr('disabled', show);
}

function toggleResetButton(show=true) {
    $('#user_rest_btn').attr('disabled', show);
}

$('#resetUserModal').on('show.bs.modal', function (e) {
    $('#user_reset_form').trigger("reset");
  })

$("#user_reset_form").validate({
    submitHandler: function () {
        reset();
    },
    rules: {
        password: {
            required: true,
        },
    },
});

function reset() {
    let form = $("#user_reset_form");

    toggleResetButton(true);

    $.ajax({
        type: "POST",
        url: form.attr("action"),
        data: form.serialize(),
        success: function (response) {
            console.log(response);
            toggleResetButton(false);

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

            Swal.fire({
                icon: 'error',
                title: 'Oops!',
                text: response.msg,
                showConfirmButton: false,
                timer: 2000
              });
            return;
        },
        error: function (request, status, error) {
            console.error("error :>> ", request.responseText);
            toggleResetButton(false);
            
            Swal.fire({
                icon: 'question',
                title: 'Oops!',
                text: request.responseJSON.message,
                showConfirmButton: false,
                timer: 2000
              });
            return;
        },
    });
}