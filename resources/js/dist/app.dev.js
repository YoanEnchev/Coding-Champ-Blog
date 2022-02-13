"use strict";

var _vueChatScroll = _interopRequireDefault(require("vue-chat-scroll"));

var _puzzlesAndQuestionsEdit = _interopRequireDefault(require("./puzzlesAndQuestionsEdit"));

var _general = _interopRequireDefault(require("./general"));

var _tutorialsPriority = _interopRequireDefault(require("./tutorialsPriority"));

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { "default": obj }; }

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
require('./bootstrap');

window.Vue = require('vue');
Vue.use(_vueChatScroll["default"]);
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */
// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('chats', require('./components/ChatsComponent.vue')["default"]);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

var app = new Vue({
  el: '#app'
});

if ($('.opened-test').length) {
  _puzzlesAndQuestionsEdit["default"].init();

  _general["default"].init();
}

if ($('.tutorials-priority').length) {
  _tutorialsPriority["default"].init();
}