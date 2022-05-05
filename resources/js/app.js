import $ from "jquery";
global.jQuery = global.$ = $; // Load jquery so it can be used by Bootstrap 4.
import bootstrap from 'bootstrap'


import general from './general';
import tutorialsPriority from './tutorialsPriority';
import tutorialsListing from './tutorialsListing';
import CategoriesBtns from './CategoriesBtns';
import TutorialsShow from './tutorialsShow';

general.init();

if($('.tutorials-priority').length) {
    tutorialsPriority.init();
}

if($('.tutorials-listing-page').length) {
    tutorialsListing.init();
}

if($('.categories-btns button').length) {
    CategoriesBtns.init();
}

if($('.tutorial-content').length) {
    TutorialsShow.init();
}