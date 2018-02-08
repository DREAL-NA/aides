@extends('layouts.bko')

@section('heading', "Ajout d'une organisation")

@section('content')
    @include('bko.components.forms._default', [
        'model' => $organizationType,
        'options' => [ 'method' => 'POST', 'url' => action('Bko\OrganizationTypeController@store') ]
    ])
@endsection