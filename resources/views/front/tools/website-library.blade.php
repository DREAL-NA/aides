@extends('layouts.app')

@section('meta_title', "Sitothèque")

@section('breadcrumb')
    <li>
        <span>Outils</span>
        <span class="chevron">></span>
    </li>
    <li>
        <span>Sitothèque</span>
    </li>
@endsection

@section('content')
    <div class="page-content page-websites">
        <h2>Sitothèque</h2>
        <div class="content">
            <section class="website-items">
                <div class="website-items-header">
                    <div class="middle full no-border-left infos slim">Informations</div>
                    <div class="last website-url hidden-xs slim">Site internet</div>
                </div>
                @foreach($websites as $website)
                    <article class="website-item">
                        <div class="middle full no-border-left infos">
                            <h4 class="title">{{ $website->name }}</h4>
                            <div class="description">{!! nl2br($website->description) !!}</div>
                            @if(!empty($website->themes))
                                @php($themes = collect(explode(PHP_EOL, $website->themes)))
                                <div class="common-data themes">
                                    <span class="label">Thèmes :</span>
                                    <div class="items">
                                        <p>{!! $themes->sortBy('name')->implode('</p><p>') !!}</p>
                                    </div>
                                </div>
                            @endif
                            @if(!$website->perimeters->isEmpty())
                                <div class="common-data perimeters">
                                    <span class="label">Localisations :</span>
                                    <div class="items">
                                        <p>{!! $website->perimeters->unique()->sortBy('name')->pluck('name')->implode('</p><p>') !!}</p>
                                    </div>
                                </div>
                            @endif
                            <div class="website-url visible-xs">
                                @foreach($website->url_array as $url)
                                    <a href="{{ $url }}" target="_blank"
                                       title="Aller sur le site - Ouvrir dans une nouvelle fenêtre">
                                        Aller sur le site
                                        <i class="fa fa-external-link" aria-hidden="true"></i>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                        <div class="last website-url hidden-xs">
                            @foreach($website->url_array as $url)
                                <a href="{{ $url }}" target="_blank"
                                   title="Aller sur le site - Ouvrir dans une nouvelle fenêtre">
                                    Aller sur le site
                                    <i class="fa fa-external-link" aria-hidden="true"></i>
                                </a>
                            @endforeach
                        </div>
                    </article>
                @endforeach
                @if($websites->isEmpty())
                    <p class="website-empty">Aucune site renseigné actuellement.</p>
                @endif
            </section>

            {{ $websites->links() }}

        </div>
    </div>
@endsection