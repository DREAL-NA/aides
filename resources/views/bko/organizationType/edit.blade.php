@extends('layouts.bko')

@section('heading', "Edition de la structure : ".$organizationType->name)
@section('menu-item-organizationType')
	<li class="menu-item active"><a href="{{ route('bko.structure.edit', $organizationType) }}">Edition de {{ $organizationType->name }}</a></li>
@endsection

@section('content')
	@include('bko.components.forms._default', [
		'model' => $organizationType,
		'options' => [ 'method' => 'PUT', 'url' => action('Bko\OrganizationTypeController@update', $organizationType) ]
	])
@endsection