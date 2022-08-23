!function(e){var t={};function n(r){if(t[r])return t[r].exports;var a=t[r]={i:r,l:!1,exports:{}};return e[r].call(a.exports,a,a.exports,n),a.l=!0,a.exports}n.m=e,n.c=t,n.d=function(e,t,r){n.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:r})},n.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},n.t=function(e,t){if(1&t&&(e=n(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var r=Object.create(null);if(n.r(r),Object.defineProperty(r,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var a in e)n.d(r,a,function(t){return e[t]}.bind(null,a));return r},n.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return n.d(t,"a",t),t},n.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},n.p="/",n(n.s=29)}({29:function(e,t,n){e.exports=n("ZrP6")},ZrP6:function(e,t){function n(e){return function(e){if(Array.isArray(e))return r(e)}(e)||function(e){if("undefined"!=typeof Symbol&&Symbol.iterator in Object(e))return Array.from(e)}(e)||function(e,t){if(!e)return;if("string"==typeof e)return r(e,t);var n=Object.prototype.toString.call(e).slice(8,-1);"Object"===n&&e.constructor&&(n=e.constructor.name);if("Map"===n||"Set"===n)return Array.from(e);if("Arguments"===n||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n))return r(e,t)}(e)||function(){throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}()}function r(e,t){(null==t||t>e.length)&&(t=e.length);for(var n=0,r=new Array(t);n<t;n++)r[n]=e[n];return r}function a(e,t){var n=Object.keys(e);if(Object.getOwnPropertySymbols){var r=Object.getOwnPropertySymbols(e);t&&(r=r.filter((function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable}))),n.push.apply(n,r)}return n}function o(e){for(var t=1;t<arguments.length;t++){var n=null!=arguments[t]?arguments[t]:{};t%2?a(Object(n),!0).forEach((function(t){i(e,t,n[t])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(n)):a(Object(n)).forEach((function(t){Object.defineProperty(e,t,Object.getOwnPropertyDescriptor(n,t))}))}return e}function i(e,t,n){return t in e?Object.defineProperty(e,t,{value:n,enumerable:!0,configurable:!0,writable:!0}):e[t]=n,e}var c=1e6,u=!1;$(document).ready((function(){"Numerical"===$("#result_category option:selected").text().trim()&&$(".add-new-range-btn").show(),c=$("#test_data_range_table >tbody >tr").length})),$((function(){$.ajaxSetup({headers:{"X-CSRF-Token":$('meta[name="csrf-token"]').attr("content")}})})),jQuery.validator.setDefaults({errorElement:"div",errorPlacement:function(e,t){e.addClass("invalid-feedback"),t.closest("div").append(e)},highlight:function(e,t,n){$(e).addClass("is-invalid")},unhighlight:function(e,t,n){$(e).removeClass("is-invalid")}});$("#test_data_form").validate({submitHandler:function(){var e;e=$("#test_data_form"),l(!0),$.ajax({type:"POST",url:e.attr("action"),data:e.serialize(),success:function(e){l(!1),"success"in e?Swal.fire({title:"Updated!",text:e.msg,icon:"success",allowOutsideClick:!1,allowEscapeKey:!1}).then((function(t){t.value&&window.location.replace(e.next)})):Swal.fire({icon:"error",title:"Oops...",text:"Something went wrong!"})},error:function(e,t,n){l(!1),Swal.fire({icon:"error",title:"Oops...",text:"Something went wrong!"})}})},rules:{name:{required:!0,maxlength:250},description:{required:!0,maxlength:250},test_data_result_category_id:{required:!0,maxlength:250}}});function l(){var e=!(arguments.length>0&&void 0!==arguments[0])||arguments[0];$("#test_data_save_btn").attr("disabled",e)}function s(e){e.forEach((function(e){return e.age_min&&e.age_max?e.range_min&&e.range_max?parseInt(e.age_min)>=parseInt(e.age_max)?(Swal.fire({icon:"error",title:"Oops...",text:"Min age cannot be greater than max age in "+e.age_min+", "+e.age_max}),void(u=!0)):parseInt(e.range_min)>=parseInt(e.range_max)?(Swal.fire({icon:"error",title:"Oops...",text:"Min range cannot be greater than max range in "+e.range_min+", "+e.range_max}),void(u=!0)):void 0:(Swal.fire({icon:"error",title:"Oops...",text:"Range values cannot be empty"}),void(u=!0)):(Swal.fire({icon:"error",title:"Oops...",text:"Age values cannot be empty"}),void(u=!0))}))}function d(e){var t=e.sort((function(e,t){return e.age_min-t.age_min||e.age_max-t.age_max})).map((function(e){var t=e.age_min,n=e.age_max;return[parseFloat(t),parseFloat(n)]})),r=_.uniqWith(t,_.isEqual),a=_.flatten(r);if(!g(a))return Swal.fire({icon:"error",title:"Oops...",text:"You have some conflicting age ranges. Please correct and re-submit"}),void(u=!0);var o=a.slice(1,-1),i=n(new Set(o));return o.length>=2&&o.length/2!==i.length?(Swal.fire({icon:"error",title:"Oops...",text:"You have some spaces between Age ranges. Please correct and re-submit"}),void(u=!0)):void 0}function f(e){var t=e.sort((function(e,t){return e.age_min-t.age_min||e.age_max-t.age_max})),r=_.groupBy(t,(function(e){return"".concat(e.age_min,"-").concat(e.age_max)}));Object.keys(r).forEach((function(e){var t=r[e].sort((function(e,t){return e.range_min-t.range_min||e.range_max-t.range_max})).flatMap((function(e){return[parseInt(e.range_min),parseInt(e.range_max)]}));if(!t.reduce((function(e,t){return!1!==e&&t>=e&&t})))return Swal.fire({icon:"error",title:"Oops...",text:"You have some conflicting ranges. Please correct and re-submit"}),void(u=!0);var a=t.slice(1,-1),o=n(new Set(a));return a.length>=2&&a.length/2!==o.length?(Swal.fire({icon:"error",title:"Oops...",text:"You have some spaces between ranges. Please correct and re-submit"}),void(u=!0)):void 0}))}$("#test_data_save_btn").on("click",(function(e){e.preventDefault(),function(){u=!1;var e=[],t=[],n=$("#test_data_range_table").find("select, input").serializeArray(),r=0,a={};n.forEach((function(n,c,u){var l=n.name.split(/[[\]]{1,2}/);r===parseInt(l[1])?(a=o(o({},a),i({},l[2],n.value)),Object.is(u.length-1,c)&&("M"===a.gender?e.push(a):t.push(a))):("M"===a.gender?e.push(a):t.push(a),a=o(o({},a={}),i({},l[2],n.value))),r=parseInt(l[1])})),e.length>0&&(s(e),d(e),f(e));t.length>0&&(s(t),d(t),f(t))}(),u||$("#test_data_form").submit()})),$("#result_category").on("change",(function(){"Numerical"===$("#result_category option:selected").text().trim()?(0===$("#test_data_range_table >tbody >tr").length&&preferredRangeAdd(),$(".add-new-range-btn").show(),$(".add-new-range-btn").find("input, textarea, button, select").prop("disabled",!1)):($(".add-new-range-btn").hide(),$(".add-new-range-btn").find("input, textarea, button, select").prop("disabled",!0))})),$("#add_row").on("click",(function(e){preferredRangeAdd()})),window.preferredRangeAdd=function(){$("#test_data_range_table tbody").append("<tr><td><select name='ranges["+c+"][gender]' id='gender_"+c+"' class='form-control' required><option value='M'>Male</option><option value='F'>Female</option></select</td><td><input name='ranges["+c+"][age_min]' id='age_min_"+c+"' type='text' class='form-control' required></td><td><input name='ranges["+c+"][age_max]' id='age_max_"+c+"' type='text' class='form-control' required></td><td><input name='ranges["+c+"][range_min]' id='range_min_"+c+"' type='text' class='form-control' required></td><td><input name='ranges["+c+"][range_max]' id='range_max_"+c+"' type='text' class='form-control' required></td><td><input name='ranges["+c+"][condition]' id='range_condition_"+c+"' type='text' class='form-control' required></td><td><a type='button' id='delete_row_"+c+"' class='btn btn-light' onclick='preferredRangeDelete(this);'><i class='fa fa-trash-o' aria-hidden='true'></i></a></td></tr>"),c++},window.preferredRangeDelete=function(e){$("#test_data_range_table tbody tr").length>1&&$(e).parents("tr").remove()};var g=function(e){return e.every((function(e,t,n){return!t||n[t-1]<=e}))}}});