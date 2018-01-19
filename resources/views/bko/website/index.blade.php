@extends('layouts.bko')

@section('heading', "Liste des sites de recensement")

@section('content')
	<div class="row">
		<div class="col-lg-12">
			<div class="row filters-table">
				<div class="form-group">
					<label for="filter__organizationType">Structure</label>
					<select id="filter__organizationType" class="form-control select2-filter" multiple="multiple">
						<option></option>
						@foreach($organizationTypes as $organizationType)
							<option value="{{ $organizationType->name }}">{{ $organizationType->name }}</option>
						@endforeach
					</select>
				</div>
				<div class="form-group">
					<label for="filter__perimeter">Périmètre</label>
					<select id="filter__perimeter" class="form-control select2-filter" multiple="multiple">
						<option></option>
						@foreach($perimeters as $perimeter)
							<option value="{{ $perimeter->name }}">{{ $perimeter->name }}</option>
						@endforeach
					</select>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<table class="table table-striped table-hover table-condensed" id="table__websites">
				<thead>
					<tr>
						<th>Structure</th>
						<th>Thèmes</th>
						<th>Nom</th>
						<th>Périmètre</th>
						<th>Adresse internet</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					@foreach($websites as $website)
						<tr>
							<td>{{ $website->organizationType->name }}</td>
							<td>{!! $website->themes_html !!}</td>
							<td>{{ $website->name }}</td>
							<td>{!! $website->perimeters->implode('name', ', ') !!}</td>
							<td>{{ $website->website_url }}</td>
							<td class="text-right col-actions">
								<a href="{{ route('bko.site.show', $website) }}" data-tooltip="tooltip" title="Voir la fiche"><i class="fa fa-eye" aria-hidden="true"></i></a>
								<a href="{{ route('bko.site.edit', $website) }}" data-tooltip="tooltip" title="Modifier"><i class="fa fa-pencil" aria-hidden="true"></i></a>
								<a href="#" class="deleteItemBtn" title="Supprimer" data-toggle="modal" data-target="#modalDeleteItem" data-tooltip="tooltip" data-id="{{ $website->id }}">
									<i class="fa fa-trash-o" aria-hidden="true"></i>
								</a>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
@endsection

@push('inline-script')
	<script>
		var table;

		function searchFilterArrayValues(values, column) {
			var search_values = [];
			for(var i=0; i<values.length; i++) {
				search_values.push($.fn.DataTable.ext.type.search.string($.fn.dataTable.util.escapeRegex(values[i])));
			}
			table.columns(column).search(search_values.length > 0 ? '('+search_values.join('|')+')' : '', true, false);
		}

		function filterResults() {
			searchFilterArrayValues($('#filter__organizationType').val(), 0);
			searchFilterArrayValues($('#filter__perimeter').val(), 3);
			table.draw();
		}

		(function($) {
			"use strict";

			table = $('#table__websites').DataTable({
				"columns": [
					null,
					null,
					null,
					null,
					null,
					{ "orderable": false }
				],
			});

			$('.select2-filter')
				.select2()
				.on('change', function() {
					filterResults();
				});
		})(jQuery);
	</script>
@endpush

@section('after-content')
	@include('bko.components.modals.delete', [
		'title' => "Suppression d'un site",
		'question' => "Êtes-vous sûr de vouloir supprimer ce site ?",
		'action' => 'Bko\WebsiteController@destroy',
	])
@endsection