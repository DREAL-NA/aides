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
					@foreach($callsForProjects as $callForProjects)
						@php
						$subthematic = empty($subthematics[$callForProjects->thematic->id]) ? null : $subthematics[$callForProjects->thematic->id]->firstWhere('id', $callForProjects->subthematic_id);
						@endphp
						<tr class="{{ in_array($callForProjects->id, $callsOfTheWeek->toArray()) ? 'item-of-the-week' : '' }}">
							<td>{{ $callForProjects->thematic->name }}</td>
							<td>{{ empty($subthematic) ? '' : $subthematic->name }}</td>
							<td>{{ $callForProjects->name }}</td>
							<td>{{ empty($callForProjects->closing_date) ? '' : $callForProjects->closing_date->format('d/m/Y') }}</td>
							<td>{{ $callForProjects->projectHolders->pluck('name')->implode(', ') }}</td>
							<td>{{ $callForProjects->perimeters->pluck('name')->implode(', ') }}</td>
							<td>{{ \Illuminate\Support\Str::words($callForProjects->objectives, 50) }}</td>
							<td>{{ $callForProjects->beneficiaries->pluck('type_label')->unique()->implode(', ') }}</td>
							<td class="text-right col-actions">
								<a href="{{ route('bko.call.show', $callForProjects) }}" data-tooltip="tooltip" title="Voir la fiche"><i class="fa fa-eye" aria-hidden="true"></i></a>
								<a href="{{ route('bko.call.edit', $callForProjects) }}" data-tooltip="tooltip" title="Modifier"><i class="fa fa-pencil" aria-hidden="true"></i></a>
								<a href="#" class="deleteItemBtn" title="Supprimer" data-toggle="modal" data-target="#modalDeleteItem" data-tooltip="tooltip"data-id="{{ $callForProjects->id }}">
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

		function filterResults() {
			window.utils.searchFilterArrayValues($('#filter__thematic').val(), 0);
			window.utils.searchFilterArrayValues($('#filter__subthematic').val(), 1);
			window.utils.searchFilterArrayValues($('#filter__projectHolder').val(), 4);
			window.utils.searchFilterArrayValues($('#filter__perimeter').val(), 5);
			window.utils.searchFilterArrayValues($('#filter__beneficiary').val(), 7);

			table.draw();
		}

		(function($) {
			"use strict";

			table = $('#table__callsForProjects').DataTable({
				"columns": [
					null,
					null,
					null,
					{ "type": "date-uk" },
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