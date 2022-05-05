// TODO: import codemirror
import CodeMirror from 'codemirror';
import 'codemirror/addon/scroll/simplescrollbars';

import 'codemirror/mode/clike/clike';
import 'codemirror/mode/htmlmixed/htmlmixed';
import 'codemirror/mode/javascript/javascript';
import 'codemirror/mode/php/php';
import 'codemirror/mode/python/python';

let CodeMirrorWrapper = {
    'build': (textareas, mode, height) => {
        /* Stupidity of CodeMirror - only selector with id can be passed. */
        textareas.map((index, elem) => {
            $(elem).attr('id', index);
        });
    
        let codeExamplesIds = textareas.map(function () {
            return $(this).attr('id');
        });
    
        for(let i = 0; i < codeExamplesIds.length; i++) {
            let id = codeExamplesIds[i];
            let textarea = $(textareas.get(i));

            let cmMode = mode;

            if(textarea.hasClass('text-only')) {
                cmMode = 'text';
            }

            let cm = CodeMirror.fromTextArea(document.getElementById(id), {
                lineNumbers: textarea.hasClass('numeric-rows'),
                matchBrackets: true,
                mode: cmMode,
                // lineWrapping: true,
                scrollbarStyle: 'overlay',
                autoRefresh: true,
                //theme: 'rubyblue',
            });
    
            // Don't change editors height if specific height is not set or lines are too litle.
            if($(cm.getScrollerElement()).find('.CodeMirror-code .CodeMirror-line').length < 7 || !height) {
                height = "100%";
            }
            
            cm.setSize("100%", height === undefined ? "100%" : height);
    
            cm.on('copy', function(cm, e) {
                e.codemirrorIgnore = true;
            });
        }
    },
};

export default CodeMirrorWrapper;