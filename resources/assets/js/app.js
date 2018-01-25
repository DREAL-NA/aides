
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./front/bootstrap');

(function($) {
	"use strict";

	$('select').selectric({
		responsive: true,
		labelBuilder: function(currItem) {
			return currItem.index == 0 ? currItem.text : '<span class="selected">'+currItem.text+'</span>';
		},
		multiple: {
			separator: ', ',
			keepMenuOpen: true,
			maxLabelEntries: 3
		}
	});

	$('.form-filters').on('click', '.submit-filters', function() {
		var $data = $('.form-filters').serialize();
		var url = $('.form-filters').attr('action');

		if($data.length > 0) {
			url += '?' + $data;
		}
		document.location.href = url;
	});

	$('.form-filters').on('click', '.reset-filters', function() {
		$('.form-filters select').each(function() {
			$(this).val('').data('selectric').refresh();
		});
	});

})(jQuery);