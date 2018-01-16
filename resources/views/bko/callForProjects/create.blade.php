@extends('layouts.bko')

@section('heading', "Ajout d'un appel à projet")

@section('content')
	@include('bko.callForProjects._form', [
		'callForProjects' => $callForProjects,
		'options' => [ 'method' => 'POST', 'url' => action('Bko\CallForProjectsController@store') ]
	])
@endsection