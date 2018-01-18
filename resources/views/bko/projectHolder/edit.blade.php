@extends('layouts.bko')

@section('heading', "Edition du porteur du dispositif : ".$projectHolder->name)
@section('menu-item-projectHolder')
	<li class="menu-item active"><a href="{{ route('bko.porteur-dispositif.edit', $projectHolder) }}">Edition de {{ $projectHolder->name }}</a></li>
@endsection

@section('content')
	@include('bko.components.forms._default', [
		'model' => $projectHolder,
		'options' => [ 'method' => 'PUT', 'url' => action('Bko\ProjectHolderController@update', $projectHolder) ]
	])
@endsection