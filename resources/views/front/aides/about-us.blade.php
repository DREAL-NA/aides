@extends('layouts.app')

@section('meta_title', "Le projet")

@section('breadcrumb')
    <li>
        <span>Les aides en Nouvelle-Aquitaine</span>
        <span class="chevron">></span>
    </li>
    <li>
        <span>Qui sommes-nous ?</span>
    </li>
@endsection

@section('content')
    <div class="page-content page-simple">
        <div class="content">
            <h2>Qui sommes nous ?</h2>

            <br/>

            <h3><strong>Le projet</strong></h3>

            <p>De manière récurrente, les acteurs du territoire - collectivités, associations, entreprises, citoyens,  … - soulignent leurs difficultés à mobiliser les aides pour leurs projets de développement durable. De fait, les possibilités de financements des projets en faveur du développement durable sont nombreuses mais sont en réalité peu connues.</p>
            <p>Permettre aux porteurs de projets d’accéder aux aides qui leur sont destinés est l’objectif du site internet Aides-Développement Durable-Nouvelle-Aquitaine (ADDNA). Ce site a été lancé en 2018 par l’État en Nouvelle-Aquitaine et le développement est assuré par la Direction régionale de l’environnement, de l’aménagement et du logement Nouvelle-Aquitaine.</p>
            <p>Le but est d’optimiser le temps de recherche afin que chacun puisse se consacrer davantage à la réalisation des projets en répertoriant les aides en faveur du développement durable pour le territoire de la Nouvelle-Aquitaine.</p>

            <br>

            <h4>Quel objectif ?</h4>

            <p>Aides-Développement Durable Nouvelle-Aquitaine (ADDNA) recense les aides disponibles pour les projets de développement durable afin d’optimiser le temps de recensement des aides pour le consacrer à la réalisation des projets.</p>

            <p>Début 2018, la DREAL a créé le site Aides-Développement Durable-Nouvelle-Aquitaine (ADDNA) qui est ouvert, accessible et utilisable par tous, en phase avec les politiques publiques d’accès aux données publiques (Open data) : </p>
            <ul>
                <li>pour les financeurs afin de communiquer sur leurs aides </li>
                <li>pour les acteurs du territoire (collectivités, associations, entreprises, particuliers, citoyens) pour rechercher une aide.</li>
            </ul>

            <p>En octobre 2020 et dans le cadre du partenariat avec data.gouv, l’outil néo-aquitain Aides-Développement Durable Nouvelle-Aquitaine (ADDNA) et l’outil national Aides Territoires sont interopérables avec notamment la mise en place d’une fiche personnalisée sur les aides en faveur du développement durable pour le territoire de la Nouvelle-Aquitaine.</p>

            <br>

            <h4>Quelles aides ?</h4>
            <p>Véritable gain de temps pour se consacrer à la réalisation des projets, Aides-Développement Durable-Nouvelle-Aquitaine (ADDNA) recense les différents appels à projets, appels à manifestation d’intérêts (AMI), fonds, aides, prix, ... en cours ou à venir au niveau local, régional, national ou européen.</p>

            <br>

            <h4>Pour qui ?</h4>
            <p>Pour tous les acteurs du territoire en Nouvelle-Aquitaine : collectivités, associations, entreprises, particuliers, citoyens, ...</p>

            <br>

            <h4>Comment ?</h4>
            <p>Les informations sont présentées de manière simple et aérée. L’utilisateur peut filtrer ses recherches par mots clés ou bien via des critères plus précis (thématique, localisation, financeurs). De plus, une lettre d’information hebdomadaire sur de nouvelles aides peut-être envoyée à la suite d’une inscription en ligne.</p>

            <p>Les données mises à dispositions sont obtenues à partir de celles diffusées par les organismes.  Afin que celle-ci soit la plus exhaustive possible, nous vous encourageons à contribuer à son alimentation en indiquant le cas échéant les sources de financements dont vous auriez connaissance, en vous adressant à Sylvie FRUGIER - <a href="mailto:sylvie.frugier@developpement-durable.gouv.fr">sylvie.frugier@developpement-durable.gouv.fr</a>  -Tél. : 05 55 12 95 76 et 06 99 03 39 58.  Merci d’avance pour votre contribution !</p>

            <p>Pour accéder au site Aides-Développement Durable-Nouvelle-Aquitaine (ADDNA) : <a href="{{ config('app.url') }}">{{ config('app.url') }}</a></p>

            <br>

            <h3><strong>L'équipe</strong></h3>

            <p>Nous contacter :<br/>
            Sylvie FRUGIER<br/>
                <a href="mailto:sylvie.frugier@developpement-durable.gouv.fr">sylvie.frugier@developpement-durable.gouv.fr</a><br/>
                Tél. : 05 55 12 95 76 et 06 99 03 39 58
            </p>

        </div>
    </div>
@endsection