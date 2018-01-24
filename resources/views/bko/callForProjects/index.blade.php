@extends('layouts.bko')

@section('heading')
	<div class="heading-with-actions">
		<div class="title">{{ $title }}</div>
		@if(!$callsForProjects->isEmpty())
			<div class="actions">
				<a href="{{ route('export.xlsx', [ 'type' => 'xlsx' ]) }}" data-tooltip="tooltip" title="Exporter en Excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i></a>
				<a href="{{ route('export.xlsx', [ 'type' => 'ods' ]) }}" data-tooltip="tooltip" title="Exporter en LibreOffice"><i class="fa fa-file-text-o" aria-hidden="true"></i></a>
				<a href="{{ route('export.pdf') }}" data-tooltip="tooltip" title="Exporter en PDF"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>
			</div>
		@endif
	</div>
@endsection

@section('content')
	<div class="row">
		<div class="col-lg-12">
			<div class="row filters-table">
				<div class="form-group">
					<label for="filter__thematic">Thématique</label>
					<select id="filter__thematic" class="form-control select2-filter" multiple="multiple">
						<option></option>
						@foreach($primary_thematics as $thematic)
							<option value="{{ $thematic->name }}">{{ $thematic->name }}</option>
						@endforeach
					</select>
				</div>
				<div class="form-group">
					<label for="filter__subthematic">Sous-thématique</label>
					<select id="filter__subthematic" class="form-control select2-filter" multiple="multiple">
						<option></option>
						@foreach($primary_thematics as $primary)
							@if(empty($subthematics[$primary->id]))
								@continue
							@endif
							<optgroup label="{{ $primary->name }}">
								@foreach($subthematics[$primary->id] as $thematic)
									<option value="{{ $thematic->name }}">{{ $thematic->name }}</option>
								@endforeach
							</optgroup>
						@endforeach
					</select>
				</div>
				<div class="form-group">
					<label for="filter__projectHolder">Porteur du dispositif</label>
					<select id="filter__projectHolder" class="form-control select2-filter" multiple="multiple">
						<option></option>
						@foreach($project_holders as $project_holder)
							<option value="{{ $project_holder->name }}">{{ $project_holder->name }}</option>
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
				<div class="form-group">
					<label for="filter__beneficiary">Bénéficiaire</label>
					<select id="filter__beneficiary" class="form-control select2-filter" multiple="multiple">
						<option></option>
						@foreach(\App\Beneficiary::types() as $type)
							<option value="{{ $type }}">{{ $type }}</option>
						@endforeach
					</select>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<table class="table table-striped table-hover table-condensed" id="table__callsForProjects">
				<thead>
					<tr>
						<th>Thématique</th>
						<th>Sous-thématique</th>
						<th>Intitulé</th>
						<th>Date de clotûre</th>
						<th>Porteur du dispositif</th>
						<th>Périmètre</th>
						<th>Objectifs</th>
						<th>Bénéficiaires</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					@foreach($callsForProjects as $callForProject)
						@php
						$beneficiary = empty($callForProject->beneficiary_id) ? null : $beneficiaries->firstWhere('id', $callForProject->beneficiary_id);
						$perimeter = empty($callForProject->perimeter_id) ? null : $perimeters->firstWhere('id', $callForProject->perimeter_id);
						$project_holder = empty($callForProject->project_holder_id) ? null : $project_holders->firstWhere('id', $callForProject->project_holder_id);
						$subthematic = empty($subthematics[$callForProject->thematic->id]) ? null : $subthematics[$callForProject->thematic->id]->firstWhere('id', $callForProject->subthematic_id);
						@endphp
						<tr class="{{ in_array($callForProject->id, $callsOfTheWeek->toArray()) ? 'item-of-the-week' : '' }}">
							<td>{{ $callForProject->thematic->name }}</td>
							<td>{{ empty($subthematic) ? '' : $subthematic->name }}</td>
							<td>{{ $callForProject->name }}</td>
							<td>{{ empty($callForProject->closing_date) ? '' : $callForProject->closing_date->format('d/m/Y') }}</td>
							<td>{{ empty($project_holder) ? '' : $project_holder->name }}</td>
							<td>{{ empty($perimeter) ? '' : $perimeter->name }}</td>
							<td>{{ \Illuminate\Support\Str::words($callForProject->objectives, 50) }}</td>
							<td>{{ empty($beneficiary) ? '' : \App\Beneficiary::types()[$beneficiary->type] }}</td>
							<td class="text-right col-actions">
								<a href="{{ route('bko.call.show', $callForProject) }}" data-tooltip="tooltip" title="Voir la fiche"><i class="fa fa-eye" aria-hidden="true"></i></a>
								<a href="{{ route('bko.call.edit', $callForProject) }}" data-tooltip="tooltip" title="Modifier"><i class="fa fa-pencil" aria-hidden="true"></i></a>
								<a href="#" class="deleteItemBtn" title="Supprimer" data-toggle="modal" data-target="#modalDeleteItem" data-tooltip="tooltip"data-id="{{ $callForProject->id }}">
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
			table.columns(column).search(search_values.length > 0 ? '^('+search_values.join('|')+')$' : '', true, false);
		}

		function filterResults() {
			searchFilterArrayValues($('#filter__thematic').val(), 0);
			searchFilterArrayValues($('#filter__subthematic').val(), 1);
			searchFilterArrayValues($('#filter__projectHolder').val(), 4);
			searchFilterArrayValues($('#filter__perimeter').val(), 5);
			searchFilterArrayValues($('#filter__beneficiary').val(), 7);

			table.draw();
		}

		(function($) {
			"use strict";

			table = $('#table__callsForProjects').DataTable({
				"columns": [
					null,
					null,
					null,
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
		'title' => "Suppression d'un dispositif financier",
		'question' => "Êtes-vous sûr de vouloir supprimer ce dispositif financier ?",
		'action' => 'Bko\CallForProjectsController@destroy',
	])
@endsection