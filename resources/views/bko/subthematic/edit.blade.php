@extends('layouts.bko')

@section('heading', "Edition de la sous-thématique : ".$thematic->name)
@section('menu-item-subthematic')
	<li class="menu-item active"><a href="{{ route('bko.subthematic.edit', $thematic) }}">Edition de {{ $thematic->name }}</a></li>
@endsection

@section('content')
	@include('bko.subthematic._form', [
		'thematic' => $thematic,
		'options' => [ 'method' => 'PUT', 'url' => action('Bko\SubthematicController@update', $thematic) ]
	])
@endsection