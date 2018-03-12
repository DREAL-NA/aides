@extends('layouts.app')

@section('meta_title', "Page introuvable")

@section('breadcrumb')
    <li>
        <span>Erreur 404</span>
    </li>
@endsection

@section('content')
    <div class="page-error">
        <h3>Désolé, la page que vous recherchez est introuvable.</h3>
    </div>
@endsection