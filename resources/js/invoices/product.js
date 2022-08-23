/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 21);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/invoices/product.js":
/*!******************************************!*\
  !*** ./resources/js/invoices/product.js ***!
  \******************************************/
/*! no static exports found */
/***/ (function(module, exports) {

  function _typeof(obj) { "@babel/helpers - typeof"; if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

  /******/
  (function (modules) {
    // webpackBootstrap
  
    /******/
    // The module cache
  
    /******/
    var installedModules = {};
    /******/
  
    /******/
    // The require function
  
    /******/
  
    function __webpack_require__(moduleId) {
      /******/
  
      /******/
      // Check if module is in cache
  
      /******/
      if (installedModules[moduleId]) {
        /******/
        return installedModules[moduleId].exports;
        /******/
      }
      /******/
      // Create a new module (and put it into the cache)
  
      /******/
  
  
      var module = installedModules[moduleId] = {
        /******/
        i: moduleId,
  
        /******/
        l: false,
  
        /******/
        exports: {}
        /******/
  
      };
      /******/
  
      /******/
      // Execute the module function
  
      /******/
  
      modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
      /******/
  
      /******/
      // Flag the module as loaded
  
      /******/
  
      module.l = true;
      /******/
  
      /******/
      // Return the exports of the module
  
      /******/
  
      return module.exports;
      /******/
    }
    /******/
  
    /******/
  
    /******/
    // expose the modules object (__webpack_modules__)
  
    /******/
  
  
    __webpack_require__.m = modules;
    /******/
  
    /******/
    // expose the module cache
  
    /******/
  
    __webpack_require__.c = installedModules;
    /******/
  
    /******/
    // define getter function for harmony exports
  
    /******/
  
    __webpack_require__.d = function (exports, name, getter) {
      /******/
      if (!__webpack_require__.o(exports, name)) {
        /******/
        Object.defineProperty(exports, name, {
          enumerable: true,
          get: getter
        });
        /******/
      }
      /******/
  
    };
    /******/
  
    /******/
    // define __esModule on exports
  
    /******/
  
  
    __webpack_require__.r = function (exports) {
      /******/
      if (typeof Symbol !== 'undefined' && Symbol.toStringTag) {
        /******/
        Object.defineProperty(exports, Symbol.toStringTag, {
          value: 'Module'
        });
        /******/
      }
      /******/
  
  
      Object.defineProperty(exports, '__esModule', {
        value: true
      });
      /******/
    };
    /******/
  
    /******/
    // create a fake namespace object
  
    /******/
    // mode & 1: value is a module id, require it
  
    /******/
    // mode & 2: merge all properties of value into the ns
  
    /******/
    // mode & 4: return value when already ns object
  
    /******/
    // mode & 8|1: behave like require
  
    /******/
  
  
    __webpack_require__.t = function (value, mode) {
      /******/
      if (mode & 1) value = __webpack_require__(value);
      /******/
  
      if (mode & 8) return value;
      /******/
  
      if (mode & 4 && _typeof(value) === 'object' && value && value.__esModule) return value;
      /******/
  
      var ns = Object.create(null);
      /******/
  
      __webpack_require__.r(ns);
      /******/
  
  
      Object.defineProperty(ns, 'default', {
        enumerable: true,
        value: value
      });
      /******/
  
      if (mode & 2 && typeof value != 'string') for (var key in value) {
        __webpack_require__.d(ns, key, function (key) {
          return value[key];
        }.bind(null, key));
      }
      /******/
  
      return ns;
      /******/
    };
    /******/
  
    /******/
    // getDefaultExport function for compatibility with non-harmony modules
  
    /******/
  
  
    __webpack_require__.n = function (module) {
      /******/
      var getter = module && module.__esModule ?
      /******/
      function getDefault() {
        return module['default'];
      } :
      /******/
      function getModuleExports() {
        return module;
      };
      /******/
  
      __webpack_require__.d(getter, 'a', getter);
      /******/
  
  
      return getter;
      /******/
    };
    /******/
  
    /******/
    // Object.prototype.hasOwnProperty.call
  
    /******/
  
  
    __webpack_require__.o = function (object, property) {
      return Object.prototype.hasOwnProperty.call(object, property);
    };
    /******/
  
    /******/
    // __webpack_public_path__
  
    /******/
  
  
    __webpack_require__.p = "/";
    /******/
  
    /******/
  
    /******/
    // Load entry module and return exports
  
    /******/
  
    return __webpack_require__(__webpack_require__.s = 21);
    /******/
  })(
  /************************************************************************/
  
  /******/
  {
    /***/
    "./resources/js/invoices/product.js":
    /*!******************************************!*\
      !*** ./resources/js/invoices/product.js ***!
      \******************************************/
  
    /*! no static exports found */
  
    /***/
    function resourcesJsInvoicesProductJs(module, exports) {
      var contactMask,
          ageMask,
          hospitalFeeMask,
          patientNumberMask = null;
      $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
        $('#product').select2({
          maximumSelectionLength: 5
        });
        $('#product_stock').select2({
          maximumSelectionLength: 5
        });
        contactMask = IMask(document.getElementById('lab_contact'), {
          mask: '000 000 0000'
        });
        ageMask = IMask(document.getElementById('lab_age'), {
          mask: Number,
          scale: 0,
          signed: false,
          min: 0,
          max: 150
        });
        hospitalFeeMask = IMask(document.getElementById('lab_hospital_fee'), {
          mask: Number,
          scale: 2,
          signed: false,
          thousandsSeparator: '',
          radix: '.',
          padFractionalZeros: true,
          min: 0,
          max: 1000000
        });
        patientNumberMask = IMask(document.getElementById('lab_number'), {
          mask: Number,
          scale: 0,
          signed: false,
          thousandsSeparator: '',
          radix: '.',
          padFractionalZeros: false,
          min: 0,
          max: 9999999999
        });
        initForm();
      });
      jQuery.validator.setDefaults({
        errorElement: "div",
        errorPlacement: function errorPlacement(error, element) {
          error.addClass("invalid-feedback");
          element.closest("div").append(error);
        },
        highlight: function highlight(element, errorClass, validClass) {
          $(element).addClass("is-invalid");
        },
        unhighlight: function unhighlight(element, errorClass, validClass) {
          $(element).removeClass("is-invalid");
        }
      });
      var labInvoiceFormValidator = $("#product_invoice_form").validate({
        ignore: "#quantity",
        // debug: true,
        submitHandler: function submitHandler() {
          // calculateTotal();
          store();
        },
        rules: {
          'name[]': {
            required: true
          }
        },
        messages: {
          'name[]': {
            required: "You should add at least a one product."
          }
        },
        errorPlacement: function errorPlacement(error, element) {
          showError(error.text());
          
        }
      });
  
      function showError(e){
        // $("#add_product_error").show();
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'Something went wrong!'
        });
      }
  
      function calculateTotal() {
        var reportFee = 0;
        var hospitalFee = 0; // HACK: have to check this
  
        $('#product').children("option:selected").each(function (element) {
          reportFee += parseFloat($(this).data('fee'));
        });
        var total = (reportFee + parseFloat(hospitalFee ? hospitalFee : 0)).toFixed(2);
        var formattedTotal = total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        $('#product_total_val').html(formattedTotal);
        $('#product_total').val(total);
      }
  
      function store() {
        var form = $("#product_invoice_form");
        console.log(invoice);
        togglePaidButton(true);
        $.ajax({
          type: "POST",
          url: form.attr("action"),
          data: form.serialize(),
          success: function success(response) {
            togglePaidButton(false);
  
            if ("success" in response) {
              // clear form
              // show message
              Swal.fire({
                text: "Transaction Completed",
                icon: 'success',
                showCancelButton: true,
                reverseButtons: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Print invoice',
                cancelButtonText: 'Close'
              }).then(function (result) {
                if (result.value) {
                  window.open(response.data.invoice_pdf_url);
                }
                cancelInvoice();
              });
              return;
            } // something went wrong
            // show error msg
  
  
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Something went wrong!'
            });
            return;
          },
          error: function error(request, status, _error) {
            console.error("error :>> ", request.responseText);
            togglePaidButton(false); // something went wrong
  
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Something went wrong!'
            });
            return;
          }
        });
      }
  
      function validateaddButton() {
        var quantity = $("#quantity").val();
        var product = $("#product").val();
        var product_stock = $("#product_stock").val();
        var valid = true;

        if(quantity == ''){
          $("#quantity_zero").show();
          $("#quantity_min").hide();
          valid = false;
        }else{
          $("#quantity_zero").hide();
          if (quantity <= 0){
            $("#quantity_min").show();
            valid = false;
          }
        }
  
        if (product == '') {
          $("#select_product").show();
          valid =  false;
        } else {
          $("#select_product").hide();
        }
  
        console.log(product_stock);
  
        if (product_stock == null) {
          $("#select_stock").show();
          valid =  false;
        } else {
          $("#select_stock").hide();
        }
  
        return valid;
      }
  
      $("#quantity").change(function () {
         
          var quan = $("#quantity").val();
          
          if(quan == ''){
            $("#quantity_zero").show();
            $("#quantity_min").hide();
          }else{
            $("#quantity_zero").hide();
            if (quan <= 0){
              $("#quantity_min").show();
            }
          }

         
        });
        $("#product").change(function () {
          var product = $("#product").val();
          var product_stock = $("#product_stock").val();

          if (!(product_stock == null)) {
            $("#select_stock").hide();
          } 

          if (product == '') {
            $("#select_product").show();
          } else {
            $("#select_product").hide();
          }
        });
        $("#product_stock").change(function () {
          var product_stock = $("#product_stock").val();
          var product = $("#product").val();

          if (!(product == '')) {
            $("#select_product").hide();
          }

          if (product_stock == null) {
            $("#select_stock").show();
          } else {
            $("#select_stock").hide();
          }
        });
      $('#add_product').click(function (e) {
        if (validateaddButton()) {
          // e.preventDefault();
          // var hospitalFee = $('#lab_hospital_fee').val();
          // $('#product').children("option:selected").each(function (element) {
          //     reportFee += parseFloat($(this).data('fee'));
          // });
          total = total + $('#price').val() * $('#quantity').val();
          final = total.toFixed(2);
          var formattedTotal = final.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
          $('#product_total_val').html(formattedTotal);
          $('#product_total').val(final);
          var myObject = new Object();
          myObject.name = $("#product option:selected").text();
          myObject.quantity = $('#quantity').val();
          myObject.price = $('#price').val() * $('#quantity').val();
          transactions.push(myObject);
          item = {};
          item['name'] = $("#product option:selected").text();
          item['price'] = $('#price').val() * $('#quantity').val();
          item['quantity'] = parseFloat($('#quantity').val());
          invoice.push(item);
          $("#add_product_error").hide();
          var $myTable = $('#productTable');
          var t = $myTable.DataTable();
          t.row.add([$("#product option:selected").text(), parseFloat($('#quantity').val()), $('#price').val() * $('#quantity').val(), "<a type=\"button\" class=\"btn btn-danger delete-btn\" id=\"delete\"\n                              >Delete</a>"]).draw(false); // window.dataTable.rows.add([
          //     [
          //         invoice.length,
          //         $( "#product option:selected" ).text(),
          //         $('#quantity').val(),
          //         ($('#price').val() * $('#quantity').val()),
          //         `<a type="button" class="btn btn-danger delete-btn"
          //                         onclick="deleteproduct(invoice.length - 1)">Delete</a>`
          //     ]
          // ]).draw()

          price.push($('#price').val() * $('#quantity').val());
          quantities.push($('#quantity').val());
          product_name.push($("#product option:selected").text());
          $('#amount').val(price);
          $('#units').val(quantities);
          $('#name').val(JSON.stringify(invoice)); // $('#name').val(JSON.stringify(product_name));
          // $('#name').val(product_name);

          resetProduct();
        }
      });
  
      function initForm() {
        labInvoiceFormValidator.resetForm();
        $('#lab_patient_form').trigger("reset");
        $('#product_invoice_form').trigger("reset");
        $('#lab_number_search_btn_inactive').hide();
        $('#lab_number_search_btn_active').show(); // $('#lab_report_fee').val($('#product').children("option:selected").data('fee'));
        // $('#product').val(1).trigger('change.select2');
        // $('#product_stock').val(1).trigger('change.select2');
        // clearPatientDetails(); 
        // calculateTotal();
      }
  
      $("#lab_patient_form").validate({
        // debug: true,
        submitHandler: function submitHandler() {
          getPatient();
        },
        rules: {
          number: {
            // required: true,
            minlength: 10,
            maxlength: 10,
            number: true
          }
        }
      });
  
      function getPatient() {
        var id = $('#lab_number').val();
        var form = $("#lab_patient_form");
        var url = form.attr("action").replace("xx", id);
  
        if (id.trim() == '') {
          return;
        }
  
        $('#lab_number_search_btn_active').hide();
        $('#lab_number_search_btn_inactive').show();
        $.ajax({
          type: "GET",
          url: url,
          data: null,
          success: function success(response) {
            console.log('getPatient :>> ', response);
            $('#lab_number_search_btn_inactive').hide();
            $('#lab_number_search_btn_active').show();
  
            if ("success" in response) {
              updatePatientDetails(response.data.patient);
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
          error: function error(request, status, _error2) {
            console.error("error :>> ", request.responseText);
            $('#lab_number_search_btn_inactive').hide();
            $('#lab_number_search_btn_active').show();
            Swal.fire({
              icon: 'question',
              title: 'Cannot find the patient',
              text: 'Please recheck the patient number from receipt or create new patient.',
              showConfirmButton: false,
              timer: 2000
            });
            return;
          }
        });
      }
  
      $('#lab_clear_info_btn').click(function (e) {
        e.preventDefault();
        clearPatientDetails();
      });
  
      function resetProduct() {
        $('#product_stock').empty();
        $('#product_stock').append($('<option></option>').val(null).html(''));
        $.each(productStocks, function (i, p) {
          $('#product_stock').append($('<option></option>').val(p.id).html(p.batch_no));
        });
        $('#product').empty();
        $('#product').append($('<option></option>').val(null).html(''));
        $.each(products, function (i, p) {
          $('#product').append($('<option></option>').val(p.id).html(p.name));
        });
        $('#uom').removeAttr('value');
        $('#quantity').val(null);
        $('#price').val(null);

        $('#select_product').hide();
        $('#select_stock').hide();
        $('#quantity_zero').hide();
        $('#quantity_min').hide();
        $('#add_product_error').hide();
        
      }

      function cancelInvoice() {
        total = 0;
        transactions = [];
        price = [];
        quantities = [];
        product_name = [];
        invoice = [];
        $('#name').val([]);
        var table = $('#productTable').DataTable();
        table.clear().draw();
        $('#product_total_val').html('0.00');
        $('#product_total').val(0);
        $('#product_stock').empty();
        $('#product_stock').append($('<option></option>').val(null).html(''));
        $.each(productStocks, function (i, p) {
          $('#product_stock').append($('<option></option>').val(p.id).html(p.batch_no));
        });
        $('#product').empty();
        $('#product').append($('<option></option>').val(null).html(''));
        $.each(products, function (i, p) {
          $('#product').append($('<option></option>').val(p.id).html(p.name));
        });
        $('#uom').removeAttr('value');
        $('#quantity').val(null);
        $('#price').val(null);

        $('#select_product').hide();
        $('#select_stock').hide();
        $('#quantity_zero').hide();
        $('#quantity_min').hide();
        $('#add_product_error').hide();
      }
  
      $('#pharmacy_cancel_btn').click(function (e) {
        e.preventDefault();
        console.log('clicked on Cancel');
        console.log(invoice);
        cancelInvoice();
      });
      $('#lab_number').keyup(function (e) {
        if (e.keyCode == 13) {
          $('#lab_patient_form').submit();
        }
      });
  
      function togglePaidButton() {
        var show = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : true;
        $('#product_paid_btn').attr('disabled', show);
      }
      /***/
  
    },
  
    /***/
    21:
    /*!************************************************!*\
      !*** multi ./resources/js/invoices/product.js ***!
      \************************************************/
  
    /*! no static exports found */
  
    /***/
    function _(module, exports, __webpack_require__) {
      module.exports = __webpack_require__(
      /*! C:\xampp\htdocs\laravel\ayubo_health_web\resources\js\invoices\product.js */
      "./resources/js/invoices/product.js");
      /***/
    }
    /******/
  
  });
  
  /***/ }),
  
  /***/ 21:
  /*!************************************************!*\
    !*** multi ./resources/js/invoices/product.js ***!
    \************************************************/
  /*! no static exports found */
  /***/ (function(module, exports, __webpack_require__) {
  
  module.exports = __webpack_require__(/*! C:\xampp\htdocs\laravel\ayubo_health_web\resources\js\invoices\product.js */"./resources/js/invoices/product.js");
  
  
  /***/ })
  
  /******/ });