@extends('layouts.bko')

@section('heading', "Edition de l'appel à projets : ".$callForProjects->name)
@section('menu-item-call')
	<li class="menu-item active"><a href="{{ route('bko.call.edit', $callForProjects) }}">Edition de {{ $callForProjects->name }}</a></li>
@endsection

@section('content')
	@include('bko.callForProjects._form', [
		'callForProjects' => $callForProjects,
		'options' => [ 'method' => 'PUT', 'url' => action('Bko\CallForProjectsController@update', $callForProjects) ]
	])
@endsection