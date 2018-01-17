@extends('layouts.bko')

@section('heading', "Liste des sous-thématiques")

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
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<table class="table table-striped table-hover" id="table__subthematics">
				<thead>
					<tr>
						<th>Thématique</th>
						<th>Nom</th>
						<th>Description</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					@foreach($thematics as $thematic)
						<tr>
							<td>{{ is_null($thematic->parent) ? '' : $thematic->parent->name }}</td>
							<td>{{ $thematic->name }}</td>
							<td>{!! $thematic->description_html !!}</td>
							<td class="text-right">
								<a href="{{ route('bko.subthematic.edit', $thematic) }}" title="Modifier"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
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
			var filter__thematic = $.fn.dataTable.util.escapeRegex($('#filter__thematic').val());

			table.columns(0).search(filter__thematic ? '^'+filter__thematic+'$' : '', true, false).draw();
		}

		(function($) {
			"use strict";

			table = $('#table__subthematics').DataTable({
				"columns": [
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
		})(jQuery);
	</script>
@endpush