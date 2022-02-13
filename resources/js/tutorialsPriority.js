let tutorialsPriority = {
    'init': () => {
        const techEntitySelect = $('#tech-entities-select');
        const categoriesSelect = $('#categories-select');
        const tbodyPriorityListing = $('table.tutorials-priority tbody');
        const body = $('body');
        const swapBaseUrl = fromPHP.swapBaseUrl;

        const swapWithAboveTemplate = $('#swap-with-above');
        const swapWithBelowTemplate = $('#swap-with-below');

        console.log(swapBaseUrl);

        [techEntitySelect, categoriesSelect].forEach((elem) => {
            elem.change(async () => {
                let tutorials = await $.get(`${fromPHP.tutorialsBaseUrl}/${techEntitySelect.val()}/${categoriesSelect.val()}`);
                
                let optionsHtmlArr = tutorials.map((tutorial, index) => {
                    let actionsHTML = '';

                    if(index !== 0) {
                        let template = swapWithAboveTemplate.clone();
                        template.find('form').attr('action', `${swapBaseUrl}/${tutorial.id}/${tutorials[index - 1].id}`);
                        actionsHTML += template.html();
                    }

                    if(index !== tutorials.length - 1) {
                        let template = swapWithBelowTemplate.clone();
                        template.find('form').attr('action', `${swapBaseUrl}/${tutorial.id}/${tutorials[index + 1].id}`);
                        actionsHTML += template.html();
                    }
                    
                    return `<tr>
                        <td>${tutorial.pretty_name}</td>
                        <td>${actionsHTML}</td>
                    </tr>`;
                });
                tbodyPriorityListing.html(optionsHtmlArr.join());
            });
        });

        body.on('click', '.move-up', () => {
            let tr = $(e.target).closest('tr');
            let otherTr = tr.prev();

            console.log(tr.attr('data-id'), otherTr.attr('data-id'));

            $("#element1").before($("#element2"));
        });

        body.on('click', '.move-down', () => {
            let tr = $(e.target).closest('tr');
            let otherTr = tr.next();

            console.log(tr.attr('data-id'), otherTr.attr('data-id'));
        });
    }
};

export default tutorialsPriority;