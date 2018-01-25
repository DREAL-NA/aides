@extends('layouts.app')

@section('meta_title', "Fiche complète | Dispositifs financiers")

@section('breadcrumb')
	<li>
		<a href="{{ route('front.dispositifs') }}">Dispositifs financiers</a>
		<span class="chevron">></span>
	</li>
	<li>
		<span>Fiche complète</span>
	</li>
@endsection

@section('content')
	<div class="page-content page-dispositifs">
		<h2>Dispositifs financiers - Fiche complète</h2>
		<p>@TODO</p>
	</div>
@endsection