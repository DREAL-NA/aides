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
                         <p>Chef de projet "Accompagner les territoires en transition Innovation"</p>
                         <p>Mission Transition Ecologique (MTE)</p>
                        <p>DREAL Nouvelle-Aquitaine (Site Limoges)</p>
                        <p><b>05 55 12 95 76</b> ou <b>06 99 03 39 58</b></p>
                        <p><a href="mailto:{{ config('app.contact_mail') }}">{{ config('app.contact_mail') }}</a></p>
                    </div>
                </div>
            </div>

            <div class="flex-item">
                <h3>Equipe de développement</h3>
                <div class="team-items">
                    <div class="team-item">
                        <h4>Items Media Concept</h4>
                        <p><a href="https://www.imc-fr.com" target="_blank">www.imc-fr.com</a></p>
                        <p><b>05 57 35 73 73</b></p>
                        <p><a href="mailto:contac@imc-fr.com">contac@imc-fr.com</a></p>
                    </div>
                </div>

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
                <div class="team-items">
                    <div class="team-item">
                        <h4>Items Medias Concept</h4>
                        <img src="{{ asset('images/IMC.jpg') }}" alt="Agence Item Medias Concept" class="logo-image">
                        <p>4, Allée Pierre-Gilles de Gennes, 33700 MERIGNAC</p>
                        <p><a href="https://www.imc-fr.com/accueil.html" target="_blank">https://www.imc-fr.com/accueil.html</a></p>
                        <p><b>05 57 35 73 79</b> et <b>06 52 83 88 22</b></p>
                    </div>
                </div>
            </div>
            <div class="flex-item">
                <h3>Conseil en ergonomie des interfaces</h3>
            <div class="team-items">
                <div class="team-item">
                    <h4>Fanny BREUNEVAL</h4>
                    <p><a href="https://cutt.ly/fannybreuneval" target="_blank">https://cutt.ly/fannybreuneval</a></p>
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
