// window._ = require('lodash');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
    window.$ = window.jQuery = require('jquery');

    // window.selectric = require('selectric/src/jquery.selectric')
    window.selectric = require('selectric')

    require('air-datepicker');
    require('air-datepicker/dist/js/i18n/datepicker.fr');
    require('./menu');

    window.vex = require('vex-js');
    window.vex.registerPlugin(require('vex-dialog'));
    window.vex.defaultOptions.className = 'vex-theme-plain';
} catch (e) {
}

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    $.ajaxSetup({
        beforeSend: function (xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", token.content);
        }
    });
    // window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}