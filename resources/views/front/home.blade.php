@extends('layouts.app')

@section('meta_title', "Accueil")

@section('breadcrumb')


@section('content')
    {{-- <div class="count-dispositifs-wrapper">
         <div class="count-dispositifs">
             {!! trans_choice('messages.home.count', $countCallsForProjects) !!}
         </div>
        <a class="count-dispositifs-link" href="{{ route('front.dispositifs') }}">Voir les aides</a>
     </div>--}}

     <div class="page-container">

         <div class="page-header">
             <h2 class="text-center principal">Un projet de développement durable ?
             <br/><span style="padding-top: 10px;" class="count-dispositifs">{!! trans_choice('messages.home.count', $countCallsForProjects) !!}</span> financières pour vous</h2>

             <p class="text-center sous-titre">Associations, citoyens, collectivités, entreprises,... </p>

         </div>

         @include('front.research')
         {{--
         @include('front.home.quick-search')

         <div>
             <a id="dispositifs-filters-button" href="#">
                 <span>Filtrer</span>
                 <i class="fa fa-plus"></i>
                 <i class="fa fa-minus"></i>
             </a>

             <div id="dispositifs-filters-container">
                 @include('front.dispositifs.filters')
             </div>
         </div> --}}

         {{--@include('front.home.advanced-search')--}}

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