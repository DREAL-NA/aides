
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./front/bootstrap');

function getDispositifs() {
	var $data = $('.form-filters').serialize();
	var url = $('.form-filters').attr('action');

	if($data.length > 0) {
		url += '?' + $data;
	}
	document.location.href = url;
}

(function($) {
	"use strict";

	$('.menu-list').menu();

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

	$('.form-home').on('click', '.submit-filters', function() {
		console.log($('.selectPerimeter').val());
		if(!$('.thematics_hidden').get(0)) {
			window.vex.dialog.alert("Vous devez sélectionner au moins un besoin de financement.");
			return false;
		} else if($('.selectPerimeter').val().length == 0) {
			window.vex.dialog.alert("Vous devez sélectionner au moins une localisation.");
			return false;
		}
		getDispositifs();
	});

	$('.form-dispositifs').on('click', '.submit-filters', function() {
		getDispositifs();
	});

	$('.form-dispositifs').on('click', '.reset-filters', function() {
		$('.form-filters select').each(function() {
			$(this).val('').data('selectric').refresh();
		});
	});

	$('.export-results').on('click', function(e) {
		e.preventDefault();

		var $data = window.location.href.split('?')[1];
		var url = $(this).attr('href');

		if($data !== undefined) {
			url += '?' + $data;
		}
		document.location.href = url;
	});
})(jQuery);