@extends('layouts.app')

@section('breadcrumb')
	<li>
		<a href="{{ route('front.dispositifs') }}">Dispositifs de formation</a>
		<span class="chevron">></span>
	</li>
	<li>
		<span>Fiche dispositif</span>
	</li>
@endsection

@section('content')
	<div class="page-content page-dispositifs">
		<h2>Dispositif de formation unique</h2>
		<p>@TODO</p>
	</div>
@endsection