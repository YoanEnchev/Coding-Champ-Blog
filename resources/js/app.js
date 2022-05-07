import $ from "jquery";
global.jQuery = global.$ = $; // Load jquery so it can be used by Bootstrap 4.
import bootstrap from 'bootstrap' // Loads bootstrap features even if IDE marks it as unused.

import TutorialsPriority from './TutorialsPriority';
import TutorialsListing from './TutorialsListing';
import TutorialsShow from './TutorialsShow';

if($('#tutorials-priority-listing').length) {
    TutorialsPriority.init();
}

if($('#tutorials-index').length) {
    TutorialsListing.init();
}

if($('#tutorials-show').length) {
    TutorialsShow.init();
}