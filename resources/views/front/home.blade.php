@extends('layouts.app')

@section('meta_title', "Accueil")

@section('content')
    <div class="count-dispositifs-wrapper">{!! trans_choice('messages.home.count', $countCallsForProjects) !!}</div>

    <div class="page-content page-home">
        <div class="content">
            <article class="content-home">
                <h4 class="h3 text-center">Choisir entre 1 ou 2</h4>
            </article>
        </div>
    </div>

    <div class="page-container">
        @include('front.home.quick-search')

        @include('front.home.filtered-search')

        @include('front.home.news')

        @include('front.home.websites-to-consult')
    </div>

@endsection

@push('inline-script')
    <script>
        (function ($) {
            "use strict";

            function manageThematics() {
                $('input.thematics_hidden').remove();
                var _form = $('.form-home');

                $('.step-thematic .filters-items a.active').each(function () {
                    _form.prepend($('<input type="hidden" name="{{ \App\Thematic::URI_NAME_THEMATIC }}[]">').addClass('thematics_hidden').val($(this).data('id')))
                });
            }

            $('.selectThematic').on('click', function (e) {
                e.preventDefault();

                $(this).toggleClass('active').promise().done(function () {
                    manageThematics();
                });
            });

            $('.step-thematic .select-all').on('click', function () {
                $('.selectThematic').each(function () {
                    $(this).trigger('click');
                });
            });

            $('.step-perimeter .select-all').on('click', function () {
                $('.selectPerimeter option').not(':disabled').prop('selected', true);
                $('.selectPerimeter').data('selectric').refresh();
            });

            $('.step-perimeter .select-none').on('click', function () {
                $('.selectPerimeter option').not(':disabled').prop('selected', false);
                $('.selectPerimeter').data('selectric').refresh();
            });

            $('#form-newsletter').submit(function (e) {
                e.preventDefault();

                let form = $(this);

                form.find('.alert').remove();

                $.ajax({
                    url: $(this).attr('action'),
                    method: 'post',
                    data: form.serialize(),
                    success: function (data) {
                        form.prepend($('<div class="alert alert-success">').append($('<p>').html(data)));
                    },
                    error: function (data, json) {
                        let alert = $('<div class="alert alert-danger">');

                        $.each(data.responseJSON.errors, function (k, item) {
                            $.each(item, function (k2, item2) {
                                alert.append($('<p>').html(item2));
                            });
                        });

                        form.prepend(alert);
                    }
                });
            });
        })(jQuery);
    </script>
@endpush