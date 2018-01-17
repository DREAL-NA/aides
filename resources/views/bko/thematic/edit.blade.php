@extends('layouts.bko')

@section('heading', "Edition de la thématique : ".$thematic->name)
@section('menu-item-thematic')
	<li class="menu-item active"><a href="{{ route('bko.thematic.edit', $thematic) }}">Edition de {{ $thematic->name }}</a></li>
@endsection

@section('content')
	@include('bko.components.forms._default', [
		'model' => $thematic,
		'options' => [ 'method' => 'PUT', 'url' => action('Bko\ThematicController@update', $thematic) ]
	])
@endsection