@extends('layouts.bko')

@section('heading', "Edition du site de recensement : ".$website->name)
@section('menu-item-website')
	<li class="menu-item active"><a href="{{ route('bko.site.edit', $website) }}">Edition de {{ $website->name }}</a></li>
@endsection

@section('content')
	@include('bko.website._form', [
		'callForProjects' => $website,
		'options' => [ 'method' => 'PUT', 'url' => action('Bko\WebsiteController@update', $website) ]
	])
@endsection