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

            <br>

            <h4>La démarche a pour objectif la mobilisation des dispositifs disponibles dans les domaines du développement durable et de la transition énergétique et écologique
                afin d’accéder et d’identifier les aides les plus pertinentes pour les projets des territoires.</h4>

            <br>

            <p>Les dispositifs sont les appels à projets, AMI, fonds, aides, prix, concours, etc. :</p>
            <ul>
                <li>en cours ou à venir</li>
                <li>et à différentes échelles : locales, régionales, nationales, européennes.</li>
            </ul>

            <br>

            <h4>Pourquoi ?</h4>
            <p>Pour développer une ingénierie territoriale pour les territoires afin de :</p>

            <ul>
                <li>mettre à disposition une information synthétique sur les dispositifs,</li>
                <li>relayer de l’information auprès des partenaires, des réseaux et des territoires,</li>
                <li>organiser une veille structurée, organisée et active,</li>
                <li>optimiser le temps travaillé sur le recensement des dispositifs afin de le consacrer à la réalisation du projet.</li>
                <li>…</li>
            </ul>

            <br>

            <p>Pour répondre aux enjeux du territoire et des entreprises. Par exemple :</p>

            <ul>
                <li>Quelles solutions pour stocker de l’énergie ?</li>
                <li>Comment auto-produire et auto-consommer de l’énergie ?</li>
                <li>Développer les énergies renouvelables ?</li>
                <li>Développer l’usine du futur ?</li>
                <li>Comment réduire et valoriser les déchets ?</li>
                <li>Éduquer à la nature pour modifier les comportements ?</li>
                <li>…</li>
            </ul>

            <br>

            <h4>Comment ?</h4>
            <p>Le site internet recense quotidiennement les dispositifs par thématique.</p>
            <p>
                <i>La fiche du dispositif a été rédigée à partir des informations diffusées par les organismes. Ces informations sont données à titre indicatif et ne peuvent en
                    aucun cas engager la responsabilité de la DREAL NA. L’obtention des aides est liée à des critères relatif au porteur de projet, à son projet, ainsi qu’à un
                    certain
                    nombre de conditions fixées et précisées par l’organisme. Nous vous recommandons de vous adresser directement aux organismes gestionnaires mentionnés dans la
                    fiche pour
                    déterminer si votre projet est éligible à une aide. Enfin, si vous notez des omissions ou des erreurs dans cette fiche, merci de nous adresser vos remarques :
                    <a href="mailto:{{ config('app.contact_mail') }}">{{ config('app.contact_mail') }}</a></i>
            </p>

            <div class="flex">
                <div class="flex-item">
                    <img src="/images/aides-territoires.png" alt="aides-territoires">
                </div>
                <div class="flex-item">
                    <p>Ce site internet développe aussi des liens avec la start up d'Etat Aides-territoires, portée par les ministères de la transition écologique et solidaire
                        (MTES) et de
                        la cohésion des territoires (MCT), et qui permet aux porteurs de projets:</p>

                    <ul>
                        <li>d'identifier les aides pertinentes auxquelles ils peuvent prétendre pour leurs projets</li>
                        <li>de simplifier leur candidature aux dispositifs.</li>
                    </ul>
                </div>
            </div>

            <p>Une version pilote d'Aides-territoires va être déployée au 2ème trimestre 2018. Elle concernera les projets de quartiers durables, et sera ensuite déployée sur
                d'autres types de projets.</p>

            <br>

            <b>Vous pouvez être contributeur.</b>
            <p>Si vous avez connaissance d’un dispositif non répertorié, vous pouvez faire parvenir cette information à Sylvie FRUGIER :</p>

            <p>E-mail : <a href="mailto:{{ config('app.contact_mail') }}">{{ config('app.contact_mail') }}</a></p>
            <p>Tél. : <b>05 55 12 95 76</b> et <b>06 99 03 39 58</b></p>
        </div>
    </div>
@endsection