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
/******/ 	return __webpack_require__(__webpack_require__.s = 16);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/stock/edit.js":
/*!************************************!*\
  !*** ./resources/js/stock/edit.js ***!
  \************************************/
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
  
    return __webpack_require__(__webpack_require__.s = 16);
    /******/
  })(
  /************************************************************************/
  
  /******/
  {
    /***/
    "./resources/js/stock/edit.js":
    /*!************************************!*\
      !*** ./resources/js/stock/edit.js ***!
      \************************************/
  
    /*! no static exports found */
  
    /***/
    function resourcesJsStockEditJs(module, exports) {
      $(document).ready(function () {
        res = true;
        priceres = true;
      });
      $(function () {
        $.ajaxSetup({
          headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
          }
        });
      });
      jQuery.validator.addMethod("uniqueBatchNumber", function () {
        res = batchNumberExists(sto);
        return res;
      }, "This batch number already exists.");
      jQuery.validator.addMethod("price_min", function () {
        if ($('#sell_price').val() != '') {
          if ($('#sell_price').val() <= 0) {
            priceres = false;
          } else {
            priceres = true;
          }
        } else {
          priceres = false;
        }

        return priceres;
      }, "The sell price must be greater than 0.");
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
      var reportFormValidator = $("#stock_form").validate({
        // debug: true,
        submitHandler: function submitHandler() {
       
            store();
          
        },
        rules: {
          batch_no: {
            required: true,
            maxlength: 250
          },
          batch_no: {
            required: true,
            uniqueBatchNumber: true
          },
          sell_price: {
            price_min: true,
            required: true
          }
        }
      });

      function batchNumberExists(productstocks) {
        // console.log(productstocks);
        stock_item = false;

        for (var i = 0; i < productstocks.length; i++) {
          if (productstocks[i].batch_no === $('#batch_no').val()) {
            if(productstocks[i].batch_no !== start_no){
                stock_item = true;
            }
          }
        }

        if (stock_item) {
          return false;
        } else {
          return true;
        }
      }
  
      function store() {
        var form = $("#stock_form");
        toggleSaveButton(true);
        $.ajax({
          type: "POST",
          url: form.attr("action"),
          data: form.serialize(),
          success: function success(response) {
            console.log(response);
            toggleSaveButton(false);
  
            if ("success" in response) {
              // clear form
              // show message
              Swal.fire({
                title: 'Updated!',
                text: response.msg,
                icon: 'success',
                allowOutsideClick: false,
                allowEscapeKey: false
              }).then(function (result) {
                if (result.value) {
                  window.location.replace(response.next);
                }
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
            toggleSaveButton(false); // something went wrong
  
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Something went wrong!'
            });
            return;
          }
        });
      }
  
      $('#report_save_btn').click(function (e) {
        e.preventDefault();
        $("#product_form").submit();
      });
      $('#new_product_model').on('hidden.bs.modal', function (e) {
        initForm();
      });
  
      function initForm() {
        $('#product_form').trigger("reset");
        reportFormValidator.resetForm();
      }
  
      function toggleSaveButton() {
        var show = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : true;
        $('#product_save_btn').attr('disabled', show);
      }
      /***/
  
    },
  
    /***/
    16:
    /*!******************************************!*\
      !*** multi ./resources/js/stock/edit.js ***!
      \******************************************/
  
    /*! no static exports found */
  
    /***/
    function _(module, exports, __webpack_require__) {
      module.exports = __webpack_require__(
      /*! C:\xampp\htdocs\laravel\ayubo_health_web\resources\js\stock\edit.js */
      "./resources/js/stock/edit.js");
      /***/
    }
    /******/
  
  });
  
  /***/ }),
  
  /***/ 16:
  /*!******************************************!*\
    !*** multi ./resources/js/stock/edit.js ***!
    \******************************************/
  /*! no static exports found */
  /***/ (function(module, exports, __webpack_require__) {
  
  module.exports = __webpack_require__(/*! C:\xampp\htdocs\laravel\ayubo_health_web\resources\js\stock\edit.js */"./resources/js/stock/edit.js");
  
  
  /***/ })
  
  /******/ });