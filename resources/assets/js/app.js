/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./front/bootstrap');

(function ($) {
    "use strict";

    $('.menu-list').menu();

    $('select').selectric({
        responsive: true,
        labelBuilder: function (currItem) {
            return currItem.index == 0 ? currItem.text : '<span class="selected">' + currItem.text + '</span>';
        },
        multiple: {
            separator: ', ',
            keepMenuOpen: true,
            maxLabelEntries: 3
        }
    });

    $('#filter-thematic').on('selectric-select', function (element) {
        let thematics = $(this).val();

        if (thematics.length > 0) {
            $('#filter-subthematic optgroup').attr('disabled', true);

            for (let thematic of thematics) {
                $('#filter-subthematic optgroup[data-id="' + thematic + '"]').attr('disabled', false);
            }
        } else {
            $('#filter-subthematic optgroup').attr('disabled', false);
        }

        $('#filter-subthematic').selectric('refresh');
    });

    $('.form-dispositifs').on('click', '.reset-filters', function () {
        $('.form-filters input[type="checkbox"]').prop('checked', false);

        $('.form-filters input[type="text"]').val('');

        $('.form-filters select').each(function () {
            $(this).val('').data('selectric').refresh();
        });
        // $picker.data('datepicker').clear();
    });

    $('.export-results').on('click', function (e) {
        e.preventDefault();

        var $data = window.location.href.split('?')[1];
        var url = $(this).attr('href');

        if ($data !== undefined) {
            url += '?' + $data;
        }
        document.location.href = url;
    });

    var $picker = $('#filter_closing_date').datepicker({
        language: 'fr',
        clearButton: true,
    });

    if ($('#filter_closing_date').get(0) && $('#filter_closing_date').val() != '') {
        var closingDateString = $('#filter_closing_date').val();
        var dateParts = closingDateString.split("/");
        var closingDate = new Date(dateParts[2], dateParts[1] - 1, dateParts[0]); // month is 0-based
        $picker.data('datepicker').selectDate(closingDate);
    }
})(jQuery);