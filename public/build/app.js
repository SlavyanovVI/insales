(self["webpackChunk"] = self["webpackChunk"] || []).push([["app"],{

/***/ "./assets/app.js":
/*!***********************!*\
  !*** ./assets/app.js ***!
  \***********************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _styles_app_scss__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./styles/app.scss */ "./assets/styles/app.scss");
/* harmony import */ var _bootstrap__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./bootstrap */ "./assets/bootstrap.js");
/* harmony import */ var _bootstrap__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_bootstrap__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _js_application_options__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./js/application_options */ "./assets/js/application_options.js");
/* harmony import */ var _js_application_options__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_js_application_options__WEBPACK_IMPORTED_MODULE_2__);
/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)


// start the Stimulus application



/***/ }),

/***/ "./assets/bootstrap.js":
/*!*****************************!*\
  !*** ./assets/bootstrap.js ***!
  \*****************************/
/***/ (() => {



/***/ }),

/***/ "./assets/js/application_options.js":
/*!******************************************!*\
  !*** ./assets/js/application_options.js ***!
  \******************************************/
/***/ ((__unused_webpack_module, __unused_webpack_exports, __webpack_require__) => {

/* provided dependency */ var $ = __webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js");
__webpack_require__(/*! core-js/modules/es.string.trim.js */ "./node_modules/core-js/modules/es.string.trim.js");
__webpack_require__(/*! core-js/modules/es.array.find.js */ "./node_modules/core-js/modules/es.array.find.js");
__webpack_require__(/*! core-js/modules/es.object.to-string.js */ "./node_modules/core-js/modules/es.object.to-string.js");
$(document).ready(function () {
  $('.application_options .js-create-address-book').click(function (e) {
    var button = $('.application_options .js-create-address-book');
    if ($(this).attr('disable') === 'disable') {
      e.preventDefault();
      return;
    }
    var bookNameField = $('.application_options input[name="title"]');
    bookNameField.removeClass('is-invalid');
    var title = bookNameField.val().trim();
    if (title.length === 0) {
      bookNameField.addClass('is-invalid');
      e.preventDefault();
      return;
    }
    button.attr('disable', 'disable').find('span.spinner-border').removeClass('spinner-hide');
    $.post(options.url, {
      title: title
    }, function (response) {
      if (response['type'] === 'success') {
        document.location.reload();
      } else {
        $('.application_options .errors').find('.alert').remove();
        $('.application_options .errors').append($('<div />').addClass(['alert', 'alert-warning']).text(response['message']));
        button.removeAttr('disable');
        button.find('span.spinner-border').addClass('spinner-hide');
      }
    });
    e.preventDefault();
  });
});

/***/ }),

/***/ "./assets/styles/app.scss":
/*!********************************!*\
  !*** ./assets/styles/app.scss ***!
  \********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ })

},
/******/ __webpack_require__ => { // webpackRuntimeModules
/******/ var __webpack_exec__ = (moduleId) => (__webpack_require__(__webpack_require__.s = moduleId))
/******/ __webpack_require__.O(0, ["vendors-node_modules_core-js_modules_es_array_find_js-node_modules_core-js_modules_es_object_-43a68b"], () => (__webpack_exec__("./assets/app.js")));
/******/ var __webpack_exports__ = __webpack_require__.O();
/******/ }
]);
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiYXBwLmpzIiwibWFwcGluZ3MiOiI7Ozs7Ozs7Ozs7Ozs7OztBQUFBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUMyQjs7QUFFM0I7QUFDcUI7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7QUNWakJBLENBQUMsQ0FBQ0MsUUFBUSxDQUFDLENBQUNDLEtBQUssQ0FDYixZQUNBO0VBRUlGLENBQUMsQ0FBQyw4Q0FBOEMsQ0FBQyxDQUFDRyxLQUFLLENBQ25ELFVBQVNDLENBQUMsRUFDVjtJQUVJLElBQUlDLE1BQU0sR0FBR0wsQ0FBQyxDQUFDLDhDQUE4QyxDQUFDO0lBRTlELElBQUdBLENBQUMsQ0FBQyxJQUFJLENBQUMsQ0FBQ00sSUFBSSxDQUFDLFNBQVMsQ0FBQyxLQUFLLFNBQVMsRUFDeEM7TUFDSUYsQ0FBQyxDQUFDRyxjQUFjLEVBQUU7TUFDbEI7SUFDSjtJQUVBLElBQUlDLGFBQWEsR0FBR1IsQ0FBQyxDQUFDLDBDQUEwQyxDQUFDO0lBQ2pFUSxhQUFhLENBQUNDLFdBQVcsQ0FBQyxZQUFZLENBQUM7SUFFdkMsSUFBSUMsS0FBSyxHQUFHRixhQUFhLENBQUNHLEdBQUcsRUFBRSxDQUFDQyxJQUFJLEVBQUU7SUFFdEMsSUFBR0YsS0FBSyxDQUFDRyxNQUFNLEtBQUssQ0FBQyxFQUNyQjtNQUNJTCxhQUFhLENBQUNNLFFBQVEsQ0FBQyxZQUFZLENBQUM7TUFDcENWLENBQUMsQ0FBQ0csY0FBYyxFQUFFO01BQ2xCO0lBQ0o7SUFFQUYsTUFBTSxDQUFDQyxJQUFJLENBQUMsU0FBUyxFQUFFLFNBQVMsQ0FBQyxDQUM1QlMsSUFBSSxDQUFDLHFCQUFxQixDQUFDLENBQzNCTixXQUFXLENBQUMsY0FBYyxDQUFDO0lBR2hDVCxDQUFDLENBQUNnQixJQUFJLENBQ0ZDLE9BQU8sQ0FBQ0MsR0FBRyxFQUNYO01BQ0lSLEtBQUssRUFBRUE7SUFDWCxDQUFDLEVBQ0QsVUFBU1MsUUFBUSxFQUNqQjtNQUVJLElBQUdBLFFBQVEsQ0FBQyxNQUFNLENBQUMsS0FBSyxTQUFTLEVBQ2pDO1FBQ0lsQixRQUFRLENBQUNtQixRQUFRLENBQUNDLE1BQU0sRUFBRTtNQUM5QixDQUFDLE1BRUQ7UUFFSXJCLENBQUMsQ0FBQyw4QkFBOEIsQ0FBQyxDQUFDZSxJQUFJLENBQUMsUUFBUSxDQUFDLENBQUNPLE1BQU0sRUFBRTtRQUV6RHRCLENBQUMsQ0FBQyw4QkFBOEIsQ0FBQyxDQUFDdUIsTUFBTSxDQUNwQ3ZCLENBQUMsQ0FBQyxTQUFTLENBQUMsQ0FDUGMsUUFBUSxDQUFDLENBQUMsT0FBTyxFQUFFLGVBQWUsQ0FBQyxDQUFDLENBQ3BDVSxJQUFJLENBQUNMLFFBQVEsQ0FBQyxTQUFTLENBQUMsQ0FBQyxDQUNqQztRQUVEZCxNQUFNLENBQUNvQixVQUFVLENBQUMsU0FBUyxDQUFDO1FBQzVCcEIsTUFBTSxDQUFDVSxJQUFJLENBQUMscUJBQXFCLENBQUMsQ0FDN0JELFFBQVEsQ0FBQyxjQUFjLENBQUM7TUFFakM7SUFDSixDQUFDLENBQ0o7SUFFRFYsQ0FBQyxDQUFDRyxjQUFjLEVBQUU7RUFDdEIsQ0FBQyxDQUNKO0FBQ0wsQ0FBQyxDQUNKOzs7Ozs7Ozs7Ozs7QUNyRUwiLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9hc3NldHMvYXBwLmpzIiwid2VicGFjazovLy8uL2Fzc2V0cy9qcy9hcHBsaWNhdGlvbl9vcHRpb25zLmpzIiwid2VicGFjazovLy8uL2Fzc2V0cy9zdHlsZXMvYXBwLnNjc3M/OGY1OSJdLCJzb3VyY2VzQ29udGVudCI6WyIvKlxuICogV2VsY29tZSB0byB5b3VyIGFwcCdzIG1haW4gSmF2YVNjcmlwdCBmaWxlIVxuICpcbiAqIFdlIHJlY29tbWVuZCBpbmNsdWRpbmcgdGhlIGJ1aWx0IHZlcnNpb24gb2YgdGhpcyBKYXZhU2NyaXB0IGZpbGVcbiAqIChhbmQgaXRzIENTUyBmaWxlKSBpbiB5b3VyIGJhc2UgbGF5b3V0IChiYXNlLmh0bWwudHdpZykuXG4gKi9cblxuLy8gYW55IENTUyB5b3UgaW1wb3J0IHdpbGwgb3V0cHV0IGludG8gYSBzaW5nbGUgY3NzIGZpbGUgKGFwcC5jc3MgaW4gdGhpcyBjYXNlKVxuaW1wb3J0ICcuL3N0eWxlcy9hcHAuc2Nzcyc7XG5cbi8vIHN0YXJ0IHRoZSBTdGltdWx1cyBhcHBsaWNhdGlvblxuaW1wb3J0ICcuL2Jvb3RzdHJhcCc7XG5pbXBvcnQgJy4vanMvYXBwbGljYXRpb25fb3B0aW9ucyc7XG4iLCJcclxuICAgICQoZG9jdW1lbnQpLnJlYWR5KFxyXG4gICAgICAgIGZ1bmN0aW9uKClcclxuICAgICAgICB7XHJcblxyXG4gICAgICAgICAgICAkKCcuYXBwbGljYXRpb25fb3B0aW9ucyAuanMtY3JlYXRlLWFkZHJlc3MtYm9vaycpLmNsaWNrKFxyXG4gICAgICAgICAgICAgICAgZnVuY3Rpb24oZSlcclxuICAgICAgICAgICAgICAgIHtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgbGV0IGJ1dHRvbiA9ICQoJy5hcHBsaWNhdGlvbl9vcHRpb25zIC5qcy1jcmVhdGUtYWRkcmVzcy1ib29rJyk7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgIGlmKCQodGhpcykuYXR0cignZGlzYWJsZScpID09PSAnZGlzYWJsZScpXHJcbiAgICAgICAgICAgICAgICAgICAge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICBlLnByZXZlbnREZWZhdWx0KCk7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHJldHVybjtcclxuICAgICAgICAgICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICAgICAgICAgIGxldCBib29rTmFtZUZpZWxkID0gJCgnLmFwcGxpY2F0aW9uX29wdGlvbnMgaW5wdXRbbmFtZT1cInRpdGxlXCJdJyk7XHJcbiAgICAgICAgICAgICAgICAgICAgYm9va05hbWVGaWVsZC5yZW1vdmVDbGFzcygnaXMtaW52YWxpZCcpO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICBsZXQgdGl0bGUgPSBib29rTmFtZUZpZWxkLnZhbCgpLnRyaW0oKTtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgaWYodGl0bGUubGVuZ3RoID09PSAwKVxyXG4gICAgICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgYm9va05hbWVGaWVsZC5hZGRDbGFzcygnaXMtaW52YWxpZCcpO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICBlLnByZXZlbnREZWZhdWx0KCk7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHJldHVybjtcclxuICAgICAgICAgICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICAgICAgICAgIGJ1dHRvbi5hdHRyKCdkaXNhYmxlJywgJ2Rpc2FibGUnKVxyXG4gICAgICAgICAgICAgICAgICAgICAgICAuZmluZCgnc3Bhbi5zcGlubmVyLWJvcmRlcicpXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIC5yZW1vdmVDbGFzcygnc3Bpbm5lci1oaWRlJylcclxuICAgICAgICAgICAgICAgICAgICA7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICQucG9zdChcclxuICAgICAgICAgICAgICAgICAgICAgICAgb3B0aW9ucy51cmwsXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIHRpdGxlOiB0aXRsZVxyXG4gICAgICAgICAgICAgICAgICAgICAgICB9LFxyXG4gICAgICAgICAgICAgICAgICAgICAgICBmdW5jdGlvbihyZXNwb25zZSlcclxuICAgICAgICAgICAgICAgICAgICAgICAge1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIGlmKHJlc3BvbnNlWyd0eXBlJ10gPT09ICdzdWNjZXNzJylcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBkb2N1bWVudC5sb2NhdGlvbi5yZWxvYWQoKVxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgZWxzZVxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAge1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAkKCcuYXBwbGljYXRpb25fb3B0aW9ucyAuZXJyb3JzJykuZmluZCgnLmFsZXJ0JykucmVtb3ZlKCk7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICQoJy5hcHBsaWNhdGlvbl9vcHRpb25zIC5lcnJvcnMnKS5hcHBlbmQoXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICQoJzxkaXYgLz4nKVxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgLmFkZENsYXNzKFsnYWxlcnQnLCAnYWxlcnQtd2FybmluZyddKVxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgLnRleHQocmVzcG9uc2VbJ21lc3NhZ2UnXSlcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICApO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBidXR0b24ucmVtb3ZlQXR0cignZGlzYWJsZScpO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIGJ1dHRvbi5maW5kKCdzcGFuLnNwaW5uZXItYm9yZGVyJylcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgLmFkZENsYXNzKCdzcGlubmVyLWhpZGUnKVxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIDtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgICAgICk7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgIGUucHJldmVudERlZmF1bHQoKTtcclxuICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgKVxyXG4gICAgICAgIH1cclxuICAgICkiLCIvLyBleHRyYWN0ZWQgYnkgbWluaS1jc3MtZXh0cmFjdC1wbHVnaW5cbmV4cG9ydCB7fTsiXSwibmFtZXMiOlsiJCIsImRvY3VtZW50IiwicmVhZHkiLCJjbGljayIsImUiLCJidXR0b24iLCJhdHRyIiwicHJldmVudERlZmF1bHQiLCJib29rTmFtZUZpZWxkIiwicmVtb3ZlQ2xhc3MiLCJ0aXRsZSIsInZhbCIsInRyaW0iLCJsZW5ndGgiLCJhZGRDbGFzcyIsImZpbmQiLCJwb3N0Iiwib3B0aW9ucyIsInVybCIsInJlc3BvbnNlIiwibG9jYXRpb24iLCJyZWxvYWQiLCJyZW1vdmUiLCJhcHBlbmQiLCJ0ZXh0IiwicmVtb3ZlQXR0ciJdLCJzb3VyY2VSb290IjoiIn0=