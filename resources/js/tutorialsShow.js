import CodeMirrorWrapper from './helpers/CodeMirrorWrapper';
import React from 'react';
import ReactDOM from 'react-dom/client';
import CommentsList from './components/TutorialShow/CommentsList';

let TutorialsShow = {
    'init': () => {

        ReactDOM.createRoot(document.getElementById('comments-list'))
            .render(<CommentsList comments={fromPHP.comments} />)


        // Since tutorial's DOM elements are rendered through blade, react cannot be used.
        // So it must done only via vanilla js or jquery.

        let tutorialTextareaSelector = '.tutorial-example';
        let allTextareas = $(tutorialTextareaSelector);

        $('<button type="button" class="btn copy-code mb-3">Copy Code</button>').insertAfter(`${tutorialTextareaSelector}:not(".text-only")`);

        CodeMirrorWrapper.build(allTextareas, fromPHP.cmMode);

        $('body').on('click', '.copy-code', (e) => {
            
            let btn = $(e.target);
            let code = btn.prev().prev().val()

            let textarea = document.createElement("textarea");

            textarea.style.opacity="0";
            textarea.style["pointer-events"] = "none";
            	
            $(textarea).insertAfter(btn);

            textarea.value = code;
            textarea.focus();
            textarea.select();
            document.execCommand('copy');
            $(textarea).hide();

            btn.html('Copied');

            setTimeout(() => {
                btn.text('Copy Code');
            }, 5000);
        })
    }
}

export default TutorialsShow;