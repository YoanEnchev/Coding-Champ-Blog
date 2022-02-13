
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');


import puzzlesAndQuestionsEdit from './puzzlesAndQuestionsEdit';
import general from './general';
import tutorialsPriority from './tutorialsPriority';
import tutorialsListing from './tutorialsListing';
import CategoriesBtns from './CategoriesBtns';
import TutorialsShow from './tutorialsShow';
import ProjectsPriority from './projectsPriority';
import challenges from './challenges';
import ChallengesPriority from './challengesPriority';
import ChallengeSolution from './challengeSolution';


if($('.opened-test').length) {
    puzzlesAndQuestionsEdit.init();
    general.init();
}

if($('.tutorials-priority').length) {
    tutorialsPriority.init();
}

if($('.tutorials-listing-page').length) {
    tutorialsListing.init();
}

if($('.categories-btns button').length) {
    CategoriesBtns.init();
}

if($('.opened-tutorial').length) {
    TutorialsShow.init();
}

if($('.projects-priority').length) {
    ProjectsPriority.init();
}

if($('.charpter-item').length) {
    challenges.init();
}

if($('.challenges-priority').length) {
    ChallengesPriority.init();
}

if($('.challenge-solution').length) {
    ChallengeSolution.init();
}