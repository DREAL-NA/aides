@extends('layouts.app')

@section('meta_title', "Le projet")

@section('breadcrumb')
    <li>
        <span>Qui sommes-nous ?</span>
        <span class="chevron">></span>
    </li>
    <li>
        <span>Le projet</span>
    </li>
@endsection

@section('content')
    <div class="page-content page-simple">
        <div class="content">
            <h2>Le projet</h2>

            <h3><strong>Aides-Développement Durable-Nouvelle-Aquitaine (ADDNA)</strong></h3>

            <i>« Optimiser ensemble le temps de recensement des aides pour le consacrer à la réalisation des projets »</i>

            <br>
            <br>

            <h4>Cette démarche a pour objectif la mobilisation des aides disponibles pour les projets en Nouvelle-Aquitaine.</h4>

            <br>

            <p>Les aides sont les appels à projets, AMI, fonds, aides, prix, concours, etc. :</p>
            <ul>
                <li>en cours ou à venir</li>
                <li>et à différentes échelles : locales, régionales, nationales, européennes.</li>
            </ul>

            <p><strong>Il s’agit d’un outil de veille sur les aides dans les domaines du développement durable et de la transition énergétique et écologique.</strong></p>

            <br>

            <h4>Pour qui ?</h4>
            <p><strong>Pour tous les acteurs du territoire en Nouvelle-Aquitaine : collectivités, associations, entreprises, particuliers, citoyens, ...</strong></p>

            <br>

            <h4>Pourquoi ?</h4>
            <p><strong>Pour mettre à disposition une information synthétique sur les aides auprès des partenaires, des réseaux et des territoires.</strong></p>

            <p><strong>Pour répondre aux nombreux enjeux des territoires de la Nouvelle-Aquitaine :</strong></p>
            <ul>
                <li>Quelles solutions pour stocker de l’énergie ?</li>
                <li>Comment auto-produire et auto-consommer de l’énergie ?</li>
                <li>Quelle mobilité pour mon territoire ?</li>
                <li>Développer les énergies renouvelables ?</li>
                <li>Comment réduire et valoriser les déchets ?</li>
                <li>Développer l’usine du futur ?</li>
                <li>Quelles actions pédagogiques pour promouvoir l’environnement et du développement durable ?</li>
                <li>...</li>
            </ul>

            <br>

            <h4>Comment ?</h4>
            <ul>
                <li style="font-size: 1.2em;">Pour accéder au site : <a
                            href="http://aides-developpement-nouvelle-aquitaine.fr/">http://aides-developpement-nouvelle-aquitaine.fr/</a></li>
                <li><strong>Le site internet recense quotidiennement les aides</strong> et chaque vendredi à 13h00, une actualité des aides de la semaine vous est envoyée.
                    Inscrivez-vous à notre newsletter (directement sur le site)!
                </li>
            </ul>

            <br>

            <h3 class="text-center"><span style="text-decoration: underline">Vous pouvez être contributeur.</span></h3>
            <p><strong>Si vous avez connaissance d’une aide non répertoriée, vous pouvez faire parvenir cette information à : Sylvie FRUGIER</strong> (<a
                        href="mailto:{{ config('app.contact_mail') }}">{{ config('app.contact_mail') }}</a> <strong>- Tél. :</strong> 05 55 12 95 76 et 06 99 03 39 58) <strong>ou
                    renseigner
                    directement le site</strong> <i style="font-size: .85em">(demander une demande d’ouverture de droits)</i></p>
        </div>
    </div>
@endsection