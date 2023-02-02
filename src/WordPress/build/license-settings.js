/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "jquery":
/*!*************************!*\
  !*** external "jQuery" ***!
  \*************************/
/***/ ((module) => {

module.exports = window["jQuery"];

/***/ }),

/***/ "@babel/runtime/regenerator":
/*!*************************************!*\
  !*** external "regeneratorRuntime" ***!
  \*************************************/
/***/ ((module) => {

module.exports = window["regeneratorRuntime"];

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/esm/asyncToGenerator.js":
/*!*********************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/esm/asyncToGenerator.js ***!
  \*********************************************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ _asyncToGenerator)
/* harmony export */ });
function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) {
  try {
    var info = gen[key](arg);
    var value = info.value;
  } catch (error) {
    reject(error);
    return;
  }
  if (info.done) {
    resolve(value);
  } else {
    Promise.resolve(value).then(_next, _throw);
  }
}
function _asyncToGenerator(fn) {
  return function () {
    var self = this,
      args = arguments;
    return new Promise(function (resolve, reject) {
      var gen = fn.apply(self, args);
      function _next(value) {
        asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value);
      }
      function _throw(err) {
        asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err);
      }
      _next(undefined);
    });
  };
}

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	(() => {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = (module) => {
/******/ 			var getter = module && module.__esModule ?
/******/ 				() => (module['default']) :
/******/ 				() => (module);
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be isolated against other modules in the chunk.
(() => {
/*!***************************************!*\
  !*** ./assets/js/license-settings.js ***!
  \***************************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_helpers_asyncToGenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/helpers/asyncToGenerator */ "./node_modules/@babel/runtime/helpers/esm/asyncToGenerator.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @babel/runtime/regenerator */ "@babel/runtime/regenerator");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! jquery */ "jquery");
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(jquery__WEBPACK_IMPORTED_MODULE_2__);



var getValue = function getValue(key) {
  return paidCommunitiesLicenseParams[key] || null;
};
var activate = function activate() {
  var key = getValue('pluginName');
  var id = "#".concat(key, "_license");
  var license = jquery__WEBPACK_IMPORTED_MODULE_2___default()(id).val();
  return new Promise(function (resolve) {
    jquery__WEBPACK_IMPORTED_MODULE_2___default().ajax({
      type: 'POST',
      dataType: 'json',
      url: getValue('ajaxUrl'),
      data: {
        action: getValue('actions').activate,
        license: license
      }
    }).done(function (response) {
      return resolve(response);
    }).fail(function (jqXHR) {
      return resolve(response);
    });
  });
};
var deactivate = function deactivate() {
  return new Promise(function (resolve) {
    jquery__WEBPACK_IMPORTED_MODULE_2___default().ajax({
      type: 'POST',
      dataType: 'json',
      url: getValue('ajaxUrl'),
      data: {
        action: getValue('actions').deactivate
      }
    }).done(function (response) {
      return resolve(response);
    }).fail(function (jqXHR) {
      return resolve(response);
    });
  });
};
var handleButtonClick = /*#__PURE__*/function () {
  var _ref = (0,_babel_runtime_helpers_asyncToGenerator__WEBPACK_IMPORTED_MODULE_0__["default"])( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_1___default().mark(function _callee(e) {
    var response, $button, text, license, _response, _response$error;
    return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_1___default().wrap(function _callee$(_context) {
      while (1) switch (_context.prev = _context.next) {
        case 0:
          $button = jquery__WEBPACK_IMPORTED_MODULE_2___default()(e.currentTarget);
          text = $button.text();
          license = getValue('license');
          _context.prev = 3;
          $button.prop('disabled', true);
          if (!(license.status !== 'active')) {
            _context.next = 12;
            break;
          }
          $button.text(getValue('i18n').activateMsg);
          _context.next = 9;
          return activate();
        case 9:
          response = _context.sent;
          _context.next = 16;
          break;
        case 12:
          $button.text(getValue('i18n').deactivateMsg);
          _context.next = 15;
          return deactivate();
        case 15:
          response = _context.sent;
        case 16:
          if (response.success) {
            _context.next = 18;
            break;
          }
          return _context.abrupt("return", addErrorMessage((_response = response) === null || _response === void 0 ? void 0 : (_response$error = _response.error) === null || _response$error === void 0 ? void 0 : _response$error.message));
        case 18:
          return _context.abrupt("return", addErrorMessage(response.data.message));
        case 21:
          _context.prev = 21;
          _context.t0 = _context["catch"](3);
          return _context.abrupt("return", addErrorMessage(_context.t0.message));
        case 24:
          _context.prev = 24;
          $button.prop('disabled', false);
          $button.text(text);
          return _context.finish(24);
        case 28:
        case "end":
          return _context.stop();
      }
    }, _callee, null, [[3, 21, 24, 28]]);
  }));
  return function handleButtonClick(_x) {
    return _ref.apply(this, arguments);
  };
}();
var addErrorMessage = function addErrorMessage(message) {
  var $message = jquery__WEBPACK_IMPORTED_MODULE_2___default()(message);
  $message.on('click', '.pc-close-notice', function () {
    $message.remove();
  });
  jquery__WEBPACK_IMPORTED_MODULE_2___default()('.pc-notices').append($message);
};
jquery__WEBPACK_IMPORTED_MODULE_2___default()(document.body).on('click', '.paidcommunities-license-btn', handleButtonClick);
})();

(this.paidCommunities = this.paidCommunities || {}).licenseSettings = __webpack_exports__;
/******/ })()
;
//# sourceMappingURL=license-settings.js.map