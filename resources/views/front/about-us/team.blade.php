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
                <h3>DREAL Nouvelle-Aquitaine</h3>

                <div class="team-items">
                    <div class="team-item">
                        <h4>Sylvie FRUGIER</h4>
                        <p>Chargée de mission développement économique</p>
                        <p>Service Mission Développement Durable (MDD)</p>
                        <p>DREAL Nouvelle-Aquitaine (Site Limoges)</p>
                        <p><b>05 55 12 95 76</b> ou <b>06 99 03 39 58</b></p>
                        <p><a href="mailto:{{ config('app.contact_mail') }}">{{ config('app.contact_mail') }}</a></p>
                    </div>
                </div>
            </div>

            <div class="flex-item">
                <h3>Développement</h3>
                <div class="team-items">
                    <div class="team-item">
                        <h4>Nicolas GIRAUD</h4>
                        <p><a href="https://www.nicolasgiraud.fr" target="_blank">https://www.nicolasgiraud.fr</a></p>
                        <p><b>06 74 31 72 31</b></p>
                        <p><a href="mailto:contact@ngiraud.me">contact@ngiraud.me</a></p>
                    </div>
                </div>

                <div class="team-items">
                    <div class="team-item">
                        <h4>Matti SCHNEIDER</h4>
                        <p><b>06 62 61 93 35</b></p>
                        <p><a href="mailto:contact@matti.consulting">contact@matti.consulting</a></p>
                    </div>
                </div>
                <div class="team-items">
                    <div class="team-item">
                        <h4>Nicolas DUPONT</h4>
                        <p><b>06 45 16 95 60</b></p>
                        <p><a href="mailto:npg.dupont@gmail.com">npg.dupont@gmail.com</a></p>
                    </div>
                </div>
            </div>
            <div class="flex-item">
                <h3>Confort d'usage et accessibilité</h3>
            <div class="team-items">
                <div class="team-item">
                    <h4>Fanny BREUNEVAL</h4>
                    <p><a href="https://www.uxmethode.fr" target="_blank">UX Methode</a></p>
                    <p><b>06 68 40 50 40</b></p>
                    <p><a href="mailto:fbreuneval@ensc.fr">Fanny.Breuneval@ensc.fr</a></p>
                </div>
            </div>
            </div>
            <div class="flex-item">
                <h3>Accompagnement à la méthode agile</h3>
                <div class="team-items">
                    <div class="team-item">
                        <h4>Les Vigies</h4>
                        <p><a href="https://lesvigies.fr" target="_blank">http://lesvigies.fr/</a></p>
                        <p><b>06 74 31 72 31</b></p>
                        <p><a href="mailto:thomas@lesvigies.fr">thomas@lesvigies.fr</a></p>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection