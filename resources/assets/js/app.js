/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the body of the page. From here, you may begin adding components to
 * the application, or feel free to tweak this setup for your needs.
 */

Vue.component('example', require('./components/Example.vue'));
Vue.component('quotation-list', require('./components/QuotationList.vue'));
Vue.component('quotation', require('./components/Quotation.vue'));
Vue.component('question-list', require('./components/QuestionList.vue'));
Vue.component('question', require('./components/Question.vue'));
Vue.component('question-choice', require('./components/QuestionChoice.vue'));
Vue.component('qualification-panel', require('./components/QualificationPanel.vue'));

const app = new Vue({
    el: 'body'
});

/**
 * Filters
 */

Vue.filter('nl2br', function (value) {
    return value.replace(/\n/g, "<br/>");
});


Vue.filter('escapeHtml', function escapeHtml(text) {
    var map = {
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;'
    };

    return text.replace(/[&<>"']/g, function(m) { return map[m]; });
});
