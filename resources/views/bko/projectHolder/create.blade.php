@extends('layouts.bko')

@section('heading', "Ajout d'un porteur de dispositifs")

@section('content')
	@include('bko.components.forms._default', [
		'model' => $projectHolder,
		'options' => [ 'method' => 'POST', 'url' => action('Bko\ProjectHolderController@store') ]
	])
@endsection