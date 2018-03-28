@extends('layouts.app')

@section('meta_title', "Accueil")

@section('content')
    <div class="count-dispositifs-wrapper">{!! trans_choice('messages.home.count', $countCallsForProjects) !!}</div>

    <div class="filters-wrapper">
        <form action="{{ route('front.dispositifs') }}" method="get" class="form-home form-filters">
            <div class="filters-step step-thematic">
                <h5 class="title">1. Préciser vos besoins</h5>
                <ul class="filters-items">
                    @foreach($thematics as $thematic)
                        <li class="filter-item">
                            <a href="#" class="selectThematic" data-id="{{ $thematic->id }}">{{ $thematic->name }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="filters-step step-perimeter">
                <h5 class="title">2. Sélectionner votre localisation</h5>
                <div class="step-perimeter-container">
                    <select name="{{ \App\Perimeter::URI_NAME }}[]" class="filters-select selectPerimeter" multiple>
                        <option disabled>Sélectionnez une localisation</option>
                        @foreach($perimeters as $perimeter)
                            <option value="{{ $perimeter->id }}">{{ $perimeter->name }}</option>
                        @endforeach
                    </select>
                    <div class="buttons">
                        <button class="select-all" type="button">Tous</button>
                        <button class="select-none" type="button">Aucun</button>
                    </div>
                </div>
            </div>
            <button type="button" class="filters-submit-button submit-filters">Rechercher</button>
        </form>
    </div>

    <div class="page-content page-home">
        <div class="content">
            <section class="content-home">
                <div class="page-header no-bottom">
                    <h3>Actualités de la semaine</h3>
                </div>

                <section class="dispositif-items">
                    <div class="dispositifs-items-header slim">
                        <div class="first thematic hidden-xs">Thématique</div>
                        <div class="middle full infos no-border-right hidden-xs">Informations</div>
                    </div>
                    @foreach($callsOfTheWeek as $thematic_id => $callsForProjects_thematic)
                        <article class="dispositif-item news-item">
                            <div class="first thematic"><span class="visible-xs">Thématique : </span>{{ $callsForProjects_thematic->first()->thematic->name }}</div>
                            <div class="middle full infos no-border-right">
                                @foreach($callsForProjects_thematic as $callForProjects)
                                    <div class="item-wrapper">
                                        @php($url = empty($callForProjects->website_url) ? route('front.dispositifs.unique', [ 'slug' => $callForProjects->slug ]) : $callForProjects->website_url)
                                        <h5 class="title">
                                            <a href="{{ $url }}" {{ empty($callForProjects->website_url) ? '' : 'target="_blank"' }}>{{ $callForProjects->name }}</a>
                                        </h5>
                                        @if(!empty($callForProjects->closing_date))
                                            <div class="closing-date">Date de clôture&nbsp;: {{ $callForProjects->closing_date->format('d/m/Y') }}</div>
                                        @endif
                                        @if(!$callForProjects->perimeters->isEmpty())
                                            <div class="perimeters">
                                                Périmètres&nbsp;: {!! $callForProjects->perimeters->unique()->sortBy('name')->pluck('name')->implode(', ') !!}
                                            </div>
                                        @endif
                                        <div class="objectives">{{ \Illuminate\Support\Str::words($callForProjects->objectives, 50) }}</div>
                                    </div>
                                @endforeach
                            </div>
                        </article>
                    @endforeach
                    @if($callsOfTheWeek->isEmpty())
                        <p class="dispositifs-empty no-bck">Aucune nouvelle aide cette semaine.</p>
                    @endif
                </section>
            </section>
        </div>
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

            $('.select-all').on('click', function () {
                $('.selectPerimeter option').not(':disabled').prop('selected', true);
                $('.selectPerimeter').data('selectric').refresh();
            });

            $('.select-none').on('click', function () {
                $('.selectPerimeter option').not(':disabled').prop('selected', false);
                $('.selectPerimeter').data('selectric').refresh();
            });

        })(jQuery);
    </script>
@endpush