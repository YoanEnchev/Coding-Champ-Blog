"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports["default"] = void 0;
var createTutorial = {
  'init': function init() {
    var techEntitySelect = $('#tech-entities-select');
    var categoriesSelect = $('#categories-select');
    var tutorialsSelect = $('#tutorials-select');
    var baseUrl = fromPHP.tutorialsBaseUrl;
    [techEntitySelect, categoriesSelect].forEach(function (elem) {
      elem.change(function _callee() {
        var tutorials, optionsHtmlArr;
        return regeneratorRuntime.async(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                _context.next = 2;
                return regeneratorRuntime.awrap($.get("".concat(fromPHP.tutorialsBaseUrl, "/").concat(techEntitySelect.val(), "/").concat(categoriesSelect.val())));

              case 2:
                tutorials = _context.sent;
                optionsHtmlArr = tutorials.map(function (tutorial) {
                  return "<option value=\"".concat(tutorial.id, "\">").concat(tutorial.pretty_name, "</option>");
                });
                tutorialsSelect.html(optionsHtmlArr.join());

              case 5:
              case "end":
                return _context.stop();
            }
          }
        });
      });
    });
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
      // if tutorial is going to be inserted first, don't send data to server
      // about insert-after tutorial/
      if ($(e.target).attr('id') === 'insert-as-first-tab') {
        // newly activated tab
        tutorialsSelect.val('');
      }
    });
  }
};
var _default = createTutorial;
exports["default"] = _default;