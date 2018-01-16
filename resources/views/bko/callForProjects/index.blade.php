@extends('layouts.bko')

@section('heading', $title)

@section('content')
	<div class="row">
		<div class="col-lg-12">
			<div class="row filters-table">
				<div class="form-group">
					<label for="filter__thematic">Thématique</label>
					<select id="filter__thematic" class="form-control select2-filter">
						<option></option>
						@foreach($primary_thematics as $thematic)
							<option value="{{ $thematic->name }}">{{ $thematic->name }}</option>
						@endforeach
					</select>
				</div>
				<div class="form-group">
					<label for="filter__subthematic">Sous-thématique</label>
					<select id="filter__subthematic" class="form-control select2-filter">
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
					<select id="filter__projectHolder" class="form-control select2-filter">
						<option></option>
						@foreach($project_holders as $project_holder)
							<option value="{{ $project_holder->name }}">{{ $project_holder->name }}</option>
						@endforeach
					</select>
				</div>
				<div class="form-group">
					<label for="filter__perimeter">Périmètre</label>
					<select id="filter__perimeter" class="form-control select2-filter">
						<option></option>
						@foreach($perimeters as $perimeter)
							<option value="{{ $perimeter->name }}">{{ $perimeter->name }}</option>
						@endforeach
					</select>
				</div>
				<div class="form-group">
					<label for="filter__beneficiary">Bénéficiaire</label>
					<select id="filter__beneficiary" class="form-control select2-filter">
						<option></option>
						@foreach($beneficiaries as $beneficiary)
							<option value="{{ $beneficiary->name }}">{{ $beneficiary->name }}</option>
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
						<th>Bénéficiaires</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					@foreach($callsForProjects as $callForProject)
						<tr>
							<td>{{ $callForProject->subthematic->parent->name }}</td>
							<td>{{ $callForProject->subthematic->name }}</td>
							<td>{{ $callForProject->name }}</td>
							<td>{{ $callForProject->closing_date->format('d/m/Y') }}</td>
							<td>{{ $callForProject->projectHolder->name }}</td>
							<td>{{ $callForProject->perimeter->name }}</td>
							<td>{{ $callForProject->beneficiary->name }}</td>
							<td class="text-right">
								<a href="{{ route('bko.call.edit', $callForProject) }}" title="Modifier"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
@endsection

@section('inline-script')
	<script>
		var table;

		function filterResults() {
			var filter__thematic = $.fn.dataTable.util.escapeRegex($('#filter__thematic').val());
			var filter__subthematic = $.fn.dataTable.util.escapeRegex($('#filter__subthematic').val());
			var filter__projectHolder = $.fn.dataTable.util.escapeRegex($('#filter__projectHolder').val());
			var filter__perimeter = $.fn.dataTable.util.escapeRegex($('#filter__perimeter').val());
			var filter__beneficiary = $.fn.dataTable.util.escapeRegex($('#filter__beneficiary').val());

			table.columns(0).search(filter__thematic ? '^'+filter__thematic+'$' : '', true, false);
			table.columns(1).search(filter__subthematic ? '^'+filter__subthematic+'$' : '', true, false);
			table.columns(4).search(filter__projectHolder ? '^'+filter__projectHolder+'$' : '', true, false);
			table.columns(5).search(filter__perimeter ? '^'+filter__perimeter+'$' : '', true, false);
			table.columns(6).search(filter__beneficiary ? '^'+filter__beneficiary+'$' : '', true, false);
			table.draw();

			table.columns(3).data().unique().each( function ( d, i ) {
				console.log(table.rows(i));
			});
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
					{ "orderable": false }
				],
			});

			$('.select2-filter').select2({
				allowClear: true,
			}).on('select2:unselecting', function() {
				$(this).data('unselecting', true);
			}).on('select2:opening', function(e) {
				if ($(this).data('unselecting')) {
					$(this).removeData('unselecting');
					e.preventDefault();
				}
			}).on('change', function() {
				filterResults();
			});

			$('#filter__closingDate').on('change', function() {
				filterResults();
			});
		})(jQuery);
	</script>
@endsection