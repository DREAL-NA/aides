@extends('layouts.bko')

@section('heading', "Ajout d'un dispositif financier")

@section('content')
	@include('bko.callForProjects._form', [
		'callForProjects' => $callForProjects,
		'options' => [ 'method' => 'POST', 'url' => action('Bko\CallForProjectsController@store') ]
	])
@endsection