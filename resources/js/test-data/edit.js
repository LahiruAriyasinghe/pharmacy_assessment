var last_id = 1000000;
var HAS_ERRORS = false;

$(document).ready(function () {
    if ($("#result_category option:selected").text().trim() === 'Numerical') {
        $('.add-new-range-btn').show();
    }
    last_id = $('#test_data_range_table >tbody >tr').length;
});

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

var testDataFormValidator = $("#test_data_form").validate({
    // debug: true,
    submitHandler: function () {
        store();
    },
    rules: {
        name: {
            required: true,
            maxlength: 250,
        },
        description: {
            required: true,
            maxlength: 250,
        },
        test_data_result_category_id: {
            required: true,
            maxlength: 250,
        },
    },
});

function store() {
    let form = $("#test_data_form");

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
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Something went wrong!',
            });
            return;
        },
    });
}

$('#test_data_save_btn').on('click', function (e) {
    e.preventDefault();
    checkForRangeErrors();
    if (!HAS_ERRORS) {
        $("#test_data_form").submit();
    }
});

function toggleSaveButton(show = true) {
    $('#test_data_save_btn').attr('disabled', show);
}

///////////////////////////////
// Preferred Range Functions//
//////////////////////////////

$('#result_category').on('change', function () {
    var opt = $("#result_category option:selected").text().trim();
    if (opt === 'Numerical') {
        if ($('#test_data_range_table >tbody >tr').length === 0) {
            preferredRangeAdd();
        }
        $('.add-new-range-btn').show();
        $('.add-new-range-btn').find('input, textarea, button, select').prop('disabled', false);
    } else {
        $('.add-new-range-btn').hide();
        $('.add-new-range-btn').find('input, textarea, button, select').prop('disabled', true);
    }
});

$("#add_row").on('click', function (event) {
    preferredRangeAdd();
});

window.preferredRangeAdd = function () {
    $("#test_data_range_table tbody").append("<tr>" +
        "<td><select name='ranges[" + last_id + "][gender]' id='gender_" + last_id + "' class='form-control' required><option value='M'>Male</option><option value='F'>Female</option></select</td>" +
        "<td><input name='ranges[" + last_id + "][age_min]' id='age_min_" + last_id + "' type='text' class='form-control' required></td>" +
        "<td><input name='ranges[" + last_id + "][age_max]' id='age_max_" + last_id + "' type='text' class='form-control' required></td>" +
        "<td><input name='ranges[" + last_id + "][range_min]' id='range_min_" + last_id + "' type='text' class='form-control' required></td>" +
        "<td><input name='ranges[" + last_id + "][range_max]' id='range_max_" + last_id + "' type='text' class='form-control' required></td>" +
        "<td><input name='ranges[" + last_id + "][condition]' id='range_condition_" + last_id + "' type='text' class='form-control' required></td>" +
        "<td><a type='button' id='delete_row_" + last_id + "' class='btn btn-light' onclick='preferredRangeDelete(this);'><i class='fa fa-trash-o' aria-hidden='true'></i></a></td>" +
        "</tr>");
    last_id++;
}

window.preferredRangeDelete = function (deleteControl) {
    if ($('#test_data_range_table tbody tr').length > 1) {
        $(deleteControl).parents("tr").remove();
    }
}

function checkForRangeErrors() {
    HAS_ERRORS = false;
    let maleArray = [];
    let femaleArray = [];

    const serializeArray = $('#test_data_range_table').find('select, input').serializeArray();

    let lastKey = 0;
    let lastObj = {};

    serializeArray.forEach((item, key, arr) => {
        var parts = item.name.split(/[[\]]{1,2}/);

        if (lastKey === parseInt(parts[1])) {
            // push to last obj
            lastObj = { ...lastObj, ...{ [parts[2]]: item.value } };
            if (Object.is(arr.length - 1, key)) {
                lastObj.gender === 'M' ? maleArray.push(lastObj) : femaleArray.push(lastObj);
            }
        } else {
            // push to new obj
            lastObj.gender === 'M' ? maleArray.push(lastObj) : femaleArray.push(lastObj);
            lastObj = {};
            lastObj = { ...lastObj, ...{ [parts[2]]: item.value } };
        }
        lastKey = parseInt(parts[1]);
    });

    if (maleArray.length > 0) {
        validateAgeAndRangeByComparison(maleArray)
        validateAgeRanges(maleArray)
        validateRangeRanges(maleArray)
    }

    if (femaleArray.length > 0) {
        validateAgeAndRangeByComparison(femaleArray)
        validateAgeRanges(femaleArray)
        validateRangeRanges(femaleArray)
    }
}

function validateAgeAndRangeByComparison(array) {
    array.forEach(rangeItem => {

        // validate age_min, age_max
        if (!(rangeItem.age_min && rangeItem.age_max)) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Age values cannot be empty',
            });
            HAS_ERRORS = true;
            return;
        }

        // range_min, range_mix
        if (!(rangeItem.range_min && rangeItem.range_max)) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Range values cannot be empty',
            });
            HAS_ERRORS = true;
            return;
        }

        // validate age_min vs age_max
        if (parseInt(rangeItem.age_min) >= parseInt(rangeItem.age_max)) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Min age cannot be greater than max age in ' + rangeItem.age_min + ', ' + rangeItem.age_max,
            });
            HAS_ERRORS = true;
            return;
        }

        // validate range_min vs range_max
        if (parseInt(rangeItem.range_min) >= parseInt(rangeItem.range_max)) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Min range cannot be greater than max range in ' + rangeItem.range_min + ', ' + rangeItem.range_max,
            });
            HAS_ERRORS = true;
            return;
        }
    })
}

function validateAgeRanges(array) {

    // sort array by age_min and age_max
    let sortedArray = array.sort(function (a, b) { return a.age_min - b.age_min || a.age_max - b.age_max; });

    // generate array of arrays from sorted array
    let arrayOfArrays = sortedArray.map(({ age_min, age_max }) => [parseFloat(age_min), parseFloat(age_max)]);

    // get unique arrays from array of arrays
    let uniqueArrays = _.uniqWith(arrayOfArrays, _.isEqual);

    // flatter array of arrays
    let flatterArray = _.flatten(uniqueArrays)

    // check flatter array is sorted
    if (!(isSorted(flatterArray))) {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'You have some conflicting age ranges. Please correct and re-submit',
        });
        HAS_ERRORS = true;
        return;
    }

    // remove first and last item in array
    let removedFirstAndLastElementArray = flatterArray.slice(1, -1);
    let removedDuplicateValues = [... new Set(removedFirstAndLastElementArray)]

    // ranges need to have pair wise values
    if (
        (removedFirstAndLastElementArray.length >= 2) &&
        (removedFirstAndLastElementArray.length / 2) !== removedDuplicateValues.length
    ) {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'You have some spaces between Age ranges. Please correct and re-submit',
        });
        HAS_ERRORS = true;
        return;
    }
}

function validateRangeRanges(array) {
    // sort array by age_min and age_max
    let sortedArray = array.sort(function (a, b) { return a.age_min - b.age_min || a.age_max - b.age_max; });

    // group arrays by ranges
    let groupedArray = _.groupBy(sortedArray, range => `${range.age_min}-${range.age_max}`);

    Object.keys(groupedArray).forEach(function (key) {
        let sortedArray = groupedArray[key].sort(function (a, b) { return a.range_min - b.range_min || a.range_max - b.range_max; });

        // create array from range_min and range_max values
        let sortedAllAgeValues = sortedArray.flatMap(a => [parseInt(a.range_min), parseInt(a.range_max)]);

        // check created array is not sorted
        if (!(!!sortedAllAgeValues.reduce((n, item) => n !== false && item >= n && item))) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'You have some conflicting ranges. Please correct and re-submit',
            });
            HAS_ERRORS = true;
            return;
        }

        // remove first and last item in array
        let removedFirstAndLastElementArray = sortedAllAgeValues.slice(1, -1);
        let removedDuplicateValues = [... new Set(removedFirstAndLastElementArray)]

        // ranges need to have pair wise values
        if (
            (removedFirstAndLastElementArray.length >= 2) &&
            (removedFirstAndLastElementArray.length / 2) !== removedDuplicateValues.length
        ) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'You have some spaces between ranges. Please correct and re-submit',
            });
            HAS_ERRORS = true;
            return;
        }
    });
}

const isSorted = arr => arr.every((v, i, a) => !i || a[i - 1] <= v);

