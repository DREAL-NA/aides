@extends('layouts.bko')

@section('heading', "Ajout d'une structure")

@section('content')
	@include('bko.forms._default', [
		'model' => $organizationType,
		'options' => [ 'method' => 'POST', 'url' => action('Bko\OrganizationTypeController@store') ]
	])
@endsection