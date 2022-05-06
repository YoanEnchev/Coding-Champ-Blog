import React from 'react';
import ReactDOM from 'react-dom/client';
import ListTutorialsByCategories from './components/TutorialsListing/ListTutorialsByCategories';

let TutorialsListing = {
    'init': () => {
        ReactDOM.createRoot(document.getElementById('list-tutorials-by-categories'))
            .render(<ListTutorialsByCategories />);
    }
}

export default TutorialsListing;