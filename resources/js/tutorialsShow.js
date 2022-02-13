import Codemirror from './helpers/Codemirror';

let TutorialsShow = {
    'init': () => {
        let allTextareas = $('textarea');

        $('<button type="button" class="btn copy-code mb-3">Copy Code</button>').insertAfter('textarea:not(".text-only")');

        Codemirror.build(allTextareas, fromPHP.cmMode);

        $('body').on('click', '.copy-code', function() {
            let btn = $(this);
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

            setTimeout(function() {
                btn.text('Copy Code');
            }, 5000);
        })
    }
}

export default TutorialsShow;