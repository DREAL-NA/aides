@extends('layouts.app')

@section('meta_title', "Accueil")

@section('content')
	<div class="count-dispositifs-wrapper">{!! trans_choice('messages.home.count', $countCallsForProjects) !!}</div>

	<div class="filters-wrapper">
		<form action="{{ route('front.dispositifs') }}" method="get" class="form-home form-filters">
			<div class="filters-step step-thematic">
				<h5 class="title">1. Préciser vos besoins en financement</h5>
				<ul class="filters-items">
					@foreach($thematics as $thematic)
						<li class="filter-item">
							<a href="#" class="selectThematic" data-id="{{ $thematic->id }}">{{ $thematic->name }}</a>
						</li>
					@endforeach
				</ul>
			</div>
			<div class="filters-step step-perimeter">
				<h5 class="title">2. Sélectionner votre localisation</h5>
				<select name="{{ \App\Perimeter::URI_NAME }}[]" class="filters-select" multiple>
					<option disabled>Sélectionnez une localisation</option>
					@foreach($perimeters as $perimeter)
						<option value="{{ $perimeter->id }}">{{ $perimeter->name }}</option>
					@endforeach
				</select>
			</div>
			<button type="button" class="filters-submit-button submit-filters">Rechercher</button>
		</form>
	</div>
@endsection

@push('inline-script')
	<script>
		(function($) {
			"use strict";

			console.log('lol');
			function manageThematics() {
				$('input.thematics_hidden').remove();
				var _form = $('.form-home');

				$('.step-thematic .filters-items a.active').each(function() {
					_form.prepend($('<input type="hidden" name="{{ \App\Thematic::URI_NAME_THEMATIC }}[]">').addClass('thematics_hidden').val($(this).data('id')))
				});
			}

			$('.selectThematic').on('click', function(e) {
				e.preventDefault();

				$(this).toggleClass('active').promise().done(function(){
					manageThematics();
				});
			});

		})(jQuery);
	</script>
@endpush