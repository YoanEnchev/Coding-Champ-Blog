"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports["default"] = void 0;
var Codemirror = {
  'build': function build(textareas, mode, height) {
    /* Stupidity of CodeMirror - only selector with id can be passed. */
    textareas.map(function (index, elem) {
      $(elem).attr('id', index);
    });
    var codeExamplesIds = textareas.map(function () {
      return $(this).attr('id');
    });

    for (var i = 0; i < codeExamplesIds.length; i++) {
      var id = codeExamplesIds[i];
      var textarea = $(textareas.get(i));

      if (textarea.hasClass('text-only')) {
        mode = 'text';
      }

      var cm = CodeMirror.fromTextArea(document.getElementById(id), {
        lineNumbers: textarea.hasClass('numeric-rows'),
        matchBrackets: true,
        mode: mode,
        readOnly: 'nocursor',
        // lineWrapping: true,
        scrollbarStyle: 'overlay',
        autoRefresh: true //theme: 'rubyblue',

      }); // Don't change editors height if specific height is not set or lines are too litle.

      if ($(cm.getScrollerElement()).find('.CodeMirror-code .CodeMirror-line').length < 7 || !height) {
        height = "100%";
      }

      cm.setSize("100%", height === undefined ? "100%" : height);
      cm.on('copy', function (cm, e) {
        // ignore copy by codemirror.  and will copy by browser
        e.codemirrorIgnore = true;
      });
    }
  }
};
var _default = Codemirror;
exports["default"] = _default;