@extends('layouts.bko')

@section('heading', "Ajout d'une thématique")

@section('content')
	@include('bko.components.forms._default', [
		'model' => $thematic,
		'options' => [ 'method' => 'POST', 'url' => action('Bko\ThematicController@store') ]
	])
@endsection