@extends('layouts.'.(request()->server->get('HTTP_HOST') == config('app.bko_subdomain') . '.' . config('app.domain') ? 'bko' : 'app'))

@section('meta_title', "Page introuvable")

@section('breadcrumb')
    <li>
        <span>Erreur 404</span>
    </li>
@endsection

@section('heading', "Erreur 404")

@section('content')
    <div class="page-error">
        <h3>Désolé, la page que vous recherchez est introuvable.</h3>
    </div>
@endsection