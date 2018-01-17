// window._ = require('lodash');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
	window.$ = window.jQuery = require('jquery');

	require('bootstrap-sass');
	require('eonasdan-bootstrap-datetimepicker');
	require('select2');

	// Datatables plugin
	require('datatables.net');
	require('datatables.net-bs');
	require('datatables.net-responsive');
	require('datatables.net-responsive-bs');
	require('mark.js')
	require('datatables.mark.js')

	// Select2 defaults
	require('./select2-default');
	require('./datatables-default');

	require('./utils');

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
		beforeSend: function (xhr)
		{
			xhr.setRequestHeader("X-CSRF-TOKEN", token.content);
		}
	});
	// window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
	console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}
