@extends('layouts.app')

@section('meta_title', "Actualités des semaines précédentes")

@section('breadcrumb')
    <li>
        <span>Aides des semaines précédentes</span>
    </li>
@endsection

@section('content')
    <div class="page-content page-news">
        <div class="content">
            <section class="content-search">
                <div class="page-header no-bottom">
                    <h2>Aides des semaines précédentes</h2>
                </div>

                @include('front.news.weeks')
            </section>
        </div>
    </div>
@endsection

@push('inline-script')
    <script>
        (function ($) {
            "use strict";

            $('.page-news').on('click', '.newsWeeks__loadMoreResults', function (e) {
                e.preventDefault();

                var container = $(this).parent();
                var loader = container.find('.newsWeeks__loading');
                loader.show();
                $(this).hide();

                $.ajax({
                    url: container.find('.newsWeeks__loadMoreResults').attr('data-href'),
                    method: 'get',
                    data: {},
                    success: function (data) {
                        $('.page-news .content-search').append(data.html);
                    },
                    error: function (data, json) {
                        console.log("An error occured");
                    },
                    complete: function (data) {
                        container.remove();
                    }
                });
            })
        })(jQuery);
    </script>
@endpush
