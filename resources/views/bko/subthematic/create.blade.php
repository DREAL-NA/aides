@extends('layouts.bko')

@section('heading', "Ajout d'une sous-thématique")

@section('content')
	@include('bko.subthematic._form', [
		'thematic' => $thematic,
		'options' => [ 'method' => 'POST', 'url' => action('Bko\SubthematicController@store') ]
	])
@endsection