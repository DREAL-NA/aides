@extends('layouts.bko')

@section('heading', "Ajout d'un site de recensement")

@section('content')
	@include('bko.website._form', [
		'website' => $website,
		'options' => [ 'method' => 'POST', 'url' => action('Bko\WebsiteController@store') ]
	])
@endsection