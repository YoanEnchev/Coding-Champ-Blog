"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports["default"] = void 0;

var _Codemirror = _interopRequireDefault(require("./helpers/Codemirror"));

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { "default": obj }; }

var puzzlesAndQuestionsEdit = {
  'init': function init() {
    var swiperContainersStrings = ['swiper-container-questions', 'swiper-container-puzzles'];
    swiperContainersStrings.forEach(function (className) {
      var swiper = new Swiper('.' + className, {
        effect: 'coverflow',
        grabCursor: true,
        centeredSlides: true,
        slidesPerView: 'auto',
        coverflowEffect: {
          rotate: 50,
          stretch: 0,
          depth: 100,
          modifier: 1,
          slideShadows: true
        },
        navigation: {
          nextEl: '.swiper-button-next',
          prevEl: '.swiper-button-prev'
        },
        pagination: {
          el: '.swiper-pagination',
          type: 'progressbar'
        }
      });
    });
    var cmMode = fromPHP.techEntity.cm_mode;

    _Codemirror["default"].build($('textarea.question-code-fragment, textarea.puzzle-code, textarea.puzzle-output'), cmMode
    /*'193px'*/
    );

    $('.opened-puzzle').find('.CodeMirror .cm-variable').each(function () {
      var elem = $(this);

      if (elem.html().trim() === 'fillword') {
        elem.addClass('missing-word');
        elem.addClass('puzzle-word');
        elem.html('?');
      }
    });
    $('.modal-ajax-form').submit(function (e) {
      e.preventDefault();
      var form = $(event.target).closest('form');
      var msgContainer = form.find('.messages');
      var successMsg = msgContainer.find('.succ-msg');
      var errorMsg = msgContainer.find('.err-msg');
      $.post(form.attr('action'), form.serialize()).done(function (response) {
        successMsg.text(response.message);
        errorMsg.text('');
      }).fail(function (response) {
        successMsg.text('');
        errorMsg.text(response.responseJSON.message);
      });
    });
    $('.puzzle-container').each(function (index, elem) {
      var puzzle = fromPHP.puzzles[index];
      var missingWords = $(elem).find('.missing-word');
      var matrix = puzzle.correct_patterns;
      var solutionElementsCount = matrix.length;
      $(elem).find('.missing-word').each(function (fillwordIndex, fillwordElem) {
        var solutionsToMissingWord = [];

        for (var i = 0; i < solutionElementsCount; i++) {
          solutionsToMissingWord.push(matrix[i][fillwordIndex]);
        }

        $(fillwordElem).html(solutionsToMissingWord.join('  or  '));
      });
    });
  }
};
var _default = puzzlesAndQuestionsEdit;
exports["default"] = _default;