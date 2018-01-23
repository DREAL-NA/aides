@extends('layouts.app')

@section('meta_title', "Accueil")

@section('content')
	<div class="count-dispositifs-wrapper">{!! trans_choice('messages.home.count', $countCallsForProjects) !!}</div>

	<div class="filters-wrapper">
		<form action="" method="get" id="filters-form">
			<input type="hidden" name="step_1[]">
			<div class="filters-step step-1">
				<h5 class="title">1. Préciser vos besoins en financement</h5>
				<ul class="filters-items">
					@foreach($thematics as $thematic)
						<li class="filter-item" data-id="{{ $thematic->id }}">
							<a href="#">{{ $thematic->name }}</a>
						</li>
					@endforeach
				</ul>
			</div>
			<div class="filters-step step-2">
				<h5 class="title">2. Sélectionner votre localisation</h5>
				<div class="select-container">
					<span class="arr"></span>
					<select name="step_2[]" id="step_2" class="filters-select">
						<option disabled>Sélectionnez une localisation</option>
						@foreach($perimeters as $perimeter)
							<option value="{{ $perimeter->id }}">{{ $perimeter->name }}</option>
						@endforeach
					</select>
				</div>
			</div>
			<button type="button" class="filters-submit-button">Rechercher</button>
		</form>
	</div>
@endsection