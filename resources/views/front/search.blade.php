@extends('layouts.app')

@section('meta_title', "Recherche : ".$query)

@section('breadcrumb')
    <li>
        <span>Recherche : {{ $query }}</span>
    </li>
@endsection

@section('content')
    <div class="page-content page-search">
        <div class="content">
            <section class="content-search">
                <div class="page-header no-bottom">
                    <h2>Votre recherche : {{ $query }} ({{ $callsForProjects->total() }} résultat{{ $callsForProjects->total() > 1 ? 's' : '' }})</h2>
                </div>

                <section class="dispositif-items search-items">
                    <div class="dispositifs-items-header slim">
                        <div class="middle full no-border-right">Dispositifs</div>
                    </div>
                    @foreach($callsForProjects as $callForProjects)
                        {{--@php($url = empty($callForProjects->website_url) ? route('front.dispositifs.unique', [ 'slug' => $callForProjects->slug ]) : $callForProjects->website_url)--}}
                        @php($url = route('front.dispositifs.unique', [ 'slug' => $callForProjects->slug ]))

                        <article class="dispositif-item news-item">
                            <div class="middle full infos no-border-right">
                                <div class="item-wrapper">
                                    <h5 class="title">
                                        <a href="{{ $url }}" {{ empty($callForProjects->website_url) ? '' : 'target="_blank"' }}>{{ $callForProjects->name }}</a>
                                    </h5>
                                    <div class="thematic">{{ $callForProjects->thematic->name }}{{ is_null($callForProjects->subthematic) ? '' : ' / '.$callForProjects->subthematic->name }}</div>
                                    @if(!empty($callForProjects->closing_date))
                                        <div class="closing-date">Date de clôture&nbsp;: {{ $callForProjects->closing_date->format('d/m/Y') }}</div>
                                    @endif
                                    @if(!$callForProjects->perimeters->isEmpty())
                                        <div class="perimeters">
                                            Périmètres&nbsp;: {!! $callForProjects->perimeters->unique()->sortBy('name')->pluck('name')->implode(', ') !!}
                                        </div>
                                    @endif
                                    <div class="objectives">{{ \Illuminate\Support\Str::words($callForProjects->objectives, 50) }}</div>
                                    <a href="{{ $url }}" class="see-record">Voir la fiche complète</a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                    @if($callsForProjects->isEmpty())
                        <p class="dispositifs-empty no-bck">Aucun résultat.</p>
                    @endif
                </section>
                {{ $callsForProjects->links() }}
            </section>
        </div>
    </div>
@endsection