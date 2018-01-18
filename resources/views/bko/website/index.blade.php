@extends('layouts.bko')

@section('heading', "Liste des sites de recensement")

@section('content')
	<div class="row">
		<div class="col-lg-12">
			<div class="row filters-table">
				<div class="form-group">
					<label for="filter__organizationType">Structure</label>
					<select id="filter__organizationType" class="form-control select2-filter">
						<option></option>
						@foreach($organizationTypes as $organizationType)
							<option value="{{ $organizationType->name }}">{{ $organizationType->name }}</option>
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
							<td>{!! $website->perimeter_html !!}</td>
							<td>{{ $website->website_url }}</td>
							<td class="text-right col-actions">
								<a href="{{ route('bko.site.edit', $website) }}" title="Modifier"><i class="fa fa-pencil" aria-hidden="true"></i></a>
								<a href="#" class="deleteItemBtn" title="Supprimer" data-toggle="modal" data-target="#modalDeleteItem" data-id="{{ $website->id }}">
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
			var filter__organizationType = $.fn.DataTable.ext.type.search.string($.fn.dataTable.util.escapeRegex($('#filter__organizationType').val()));

			table.columns(0).search(filter__organizationType ? '^'+filter__organizationType+'$' : '', true, false).draw();
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

@section('after-content')
	@include('bko.components.modals.delete', [
		'title' => "Suppression d'un site",
		'question' => "Êtes-vous sûr de vouloir supprimer ce site ?",
		'action' => 'Bko\WebsiteController@destroy',
	])
@endsection