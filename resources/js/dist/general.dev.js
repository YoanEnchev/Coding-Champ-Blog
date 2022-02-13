"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports["default"] = void 0;
var general = {
  'init': function init() {
    $('.ajax-confirm-btn').click(function (e) {
      e.preventDefault();
      var button = $(e.target);
      var form = button.closest('form');
      Swal.fire({
        title: 'Are you sure?',
        text: form.attr('data-text'),
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33'
      }).then(function (result) {
        if (result.isConfirmed) {
          form.submit();
        }
      });
    });
  }
};
var _default = general;
exports["default"] = _default;