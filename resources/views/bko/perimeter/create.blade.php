@extends('layouts.bko')

@section('heading', "Ajout d'un périmètre")

@section('content')
	@include('bko.forms._default', [
		'model' => $perimeter,
		'options' => [ 'method' => 'POST', 'url' => action('Bko\PerimeterController@store') ]
	])
@endsection