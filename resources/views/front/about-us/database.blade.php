@extends('layouts.app')

@section('meta_title', "La base de données")

@section('breadcrumb')
    <li>
        <span>Qui sommes-nous ?</span>
        <span class="chevron">></span>
    </li>
    <li>
        <span>La base de données</span>
    </li>
@endsection

@section('content')
    <div class="page-content">
        <h2>La base de données</h2>
        <div class="content">
            <p><b>La fiche de l'aide a été rédigée à partir des informations diffusées par les organismes</b> (voir dans le site, les organismes recensés à Outils, Sitothèque).
            </p>
            <p>Ces informations sont données à titre indicatif et ne peuvent en aucun cas engager la responsabilité de la DREAL NA. L’obtention des aides est liée à des critères
                relatif au porteur de projet, à son projet, ainsi qu’à un certain nombre de conditions fixées et précisées par l’organisme. Nous vous recommandons de vous adresser
                directement aux organismes gestionnaires mentionnés dans la fiche pour déterminer si votre projet est éligible à une aide. Enfin, si vous notez des omissions ou des
                erreurs dans cette fiche, merci de nous adresser vos remarques à :</p>
            <p>Sylvie FRUGIER :</p>
            <p>E-mail : <a href="mailto:{{ config('app.contact_mail') }}">{{ config('app.contact_mail') }}</a></p>
            <p>Tél. : <b>05 55 12 95 76</b> et <b>06 99 03 39 58</b></p>
        </div>
    </div>
@endsection