@extends('layouts.app')

@section('meta_title', "Poursuivre vos recherches")

@section('breadcrumb')
    <li>
        <span>Outils</span>
        <span class="chevron">></span>
    </li>
    <li>
        <span>Poursuivre les recherches</span>
    </li>
@endsection

@section('content')

<div class="page-content page-websites">
  <h2>Poursuivre les recherches</h2>
  <h3>Des aides selon votre profil</h3>
    <ul>
        <li>
            <h4><a href="https://aides-territoires.beta.gouv.fr/"
                   target="_blank"
                   rel="nofollow"
                   title="Aller sur le site - Ouvrir dans une nouvelle fenêtre">Aides-territoires</a></h4>
            <p>Collectivités, trouvez en quelques clics les aides pertinentes pour vos projets, sur vos territoires.</p>
        </li>
        <li>
            <h4><a href="http://www.aides-publiques-entreprises.eco-circulaire.fr/"
                   target="_blank"
                   rel="nofollow"
                   title="Aller sur le site - Ouvrir dans une nouvelle fenêtre">Portail des aides aux projets d'économie circulaire</a></h4>
            <p>Pour répondre au mieux aux besoins des entreprises, ce Portail a été construit en partenariat avec CCI France, le PEXE et les acteurs de l’économie
                circulaire, pourvoyeurs d’aides et futurs utilisateurs.</p>
        </li>
        <li>
            <h4><a href="http://www.aides-entreprises.fr/"
                   target="_blank"
                   rel="nofollow"
                   title="Aller sur le site - Ouvrir dans une nouvelle fenêtre">Aides-entreprises.fr</a></h4>
            <p>La base de données de référence sur les aides aux entreprises ouverte à tous.</p>
        </li>
    </ul>

        <h3>Sitothèque</h3>
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
                    <p class="dispositifs-empty">Aucun site renseigné actuellement.</p>
                @endif
            </section>

            {{ $websites->links() }}

        </div>
    </div>
@endsection
