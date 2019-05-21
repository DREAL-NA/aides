@extends('layouts.app')

@section('meta_title', "L'équipe")

@section('breadcrumb')
    <li>
        <span>Qui sommes-nous ?</span>
        <span class="chevron">></span>
    </li>
    <li>
        <span>L'équipe</span>
    </li>
@endsection

@section('content')
    <div class="page-content page-simple page-team">
        <h2>L'équipe</h2>
        <div class="content flex">
            <div class="flex-item">
                <h3>La DREAL Nouvelle-Aquitaine</h3>

                <div class="team-items">
                    <div class="team-item">
                        <h4>Sylvie FRUGIER</h4>
                        <p>Chargée de mission développement économique</p>
                        <p>Service Mission Développement Durable (MDD)</p>
                        <p>DREAL Nouvelle-Aquitaine (Site Limoges)</p>
                        <p>Téléphone : <b>05 55 12 95 76</b> ou <b>06 99 03 39 58</b></p>
                        <p>E-mail : <a href="mailto:{{ config('app.contact_mail') }}">{{ config('app.contact_mail') }}</a></p>
                    </div>
                </div>
            </div>

            <div class="flex-item">
                <h3>L'équipe de développement</h3>
                <div class="team-items">
                    <div class="team-item">
                        <h4>Nicolas GIRAUD, développeur web freelance</h4>
                        <p>Site internet : <a href="https://www.nicolasgiraud.fr" target="_blank">https://www.nicolasgiraud.fr</a></p>
                        <p>Téléphone : <b>06 74 31 72 31</b></p>
                        <p>E-mail : <a href="mailto:contact@ngiraud.me">contact@ngiraud.me</a></p>
                    </div>
                </div>
                <div class="team-items">
                    <div class="team-item">
                        <h4>Fanny BREUNEVAL, ingénieure en cognitique freelance</h4>
                        <p> Pour une interface web ergonomique et accessible.</p>
                        <p>Téléphone : <b>06 68 40 50 40</b></p>
                        <p>E-mail : <a href="mailto:fbreuneval@ensc.fr">Fanny.Breuneval@ensc.fr</a></p>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection