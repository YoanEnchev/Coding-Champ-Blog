"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports["default"] = void 0;
var tutorialsPriority = {
  'init': function init() {
    var techEntitySelect = $('#tech-entities-select');
    var categoriesSelect = $('#categories-select');
    var tbodyPriorityListing = $('table.tutorials-priority tbody');
    var body = $('body');
    var actionsTd = "<td>\n            <button class=\"btn btn-dark move-up\">\n                <i class=\"fas fa-angle-up\"></i>\n            </button>\n            <button class=\"btn btn-dark move-down\">\n                <i class=\"fas fa-angle-down\"></i>\n            </button>\n            <button class=\"btn btn-success add-tutorial\">\n                <i class=\"fas fa-plus\"></i>\n            </button>\n        </td>";
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
                  return "<tr>\n                        <td>".concat(tutorial.pretty_name, "</td>\n                        ").concat(actionsTd, "\n                    </tr>");
                });
                tbodyPriorityListing.html(optionsHtmlArr.join());

              case 5:
              case "end":
                return _context.stop();
            }
          }
        });
      });
    });
    body.on('click', '.move-up', function () {});
    body.on('click', '.move-down', function () {});
    body.on('click', '.add-tutorial', function (e) {
      console.log($(e.target));
      var row = $(e.target).closest('tr');
      $("<tr class=\"new-tutorial\">\n                <td><input class=\"form-control\"></td>\n                ".concat(actionsTd, "\n            </tr>")).insertAfter(row);
    });
  }
};
var _default = tutorialsPriority;
exports["default"] = _default;