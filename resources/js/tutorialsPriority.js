import React from 'react';
import ReactDOM from 'react-dom/client';
import TutorialsPriorityContainer from './components/TutorialsPriority/TutorialsPriorityContainer';

let TutorialsPriority = {
    'init': () => {

        ReactDOM.createRoot(document.getElementById('tutorials-priority-container'))
            .render(<TutorialsPriorityContainer 
                        techEntities={fromPHP.techEntities} 
                        categories={fromPHP.categories}
                        baseSwapUrl={fromPHP.swapBaseUrl}
                        extractTutorialsBaseUrl={fromPHP.extractTutorialsBaseUrl} />);
    }
};

export default TutorialsPriority;