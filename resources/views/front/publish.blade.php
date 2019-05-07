@extends('layouts.app')

@section('meta_title', "Publier une aide")

@section('breadcrumb')
<li>
    <span>Publier</span>
    <span class="chevron"></span>
</li>
@endsection

@section('content')
    <h2>Publier une aide</h2>
    <p>Si vous avez connaissance d’une aide non répertoriée, ou si vous souhaitez en publier régulièrement, vous pouvez faire parvenir cette information à Sylvie FRUGIER.
    <P><strong>E-mail : </strong><a href="mailto:{{ config('app.contact_mail') }}">{{ config('app.contact_mail') }}</a></P>
    <P><strong>Tél. :</strong> 05 55 12 95 76 ou 06 99 03 39 58</p>
@endsection