
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');


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