@extends('layouts.bko')

@section('heading', "Liste des thématiques")

@section('content')
	<table class="table table-striped table-hover" id="table__thematics">
		<thead>
			<tr>
				<th>Nom</th>
				<th>Description</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			@foreach($thematics as $thematic)
				<tr>
					<td>{{ $thematic->name }}</td>
					<td>{!! $thematic->description_html !!}</td>
					<td class="text-right col-actions">
						<a href="{{ route('bko.thematic.edit', $thematic) }}" data-tooltip="tooltip" title="Modifier"><i class="fa fa-pencil" aria-hidden="true"></i></a>
						<a href="#" class="deleteItemBtn" title="Supprimer" data-toggle="modal" data-target="#modalDeleteItem" data-tooltip="tooltip" data-id="{{ $thematic->id }}">
							<i class="fa fa-trash-o" aria-hidden="true"></i>
						</a>
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
@endsection

@push('inline-script')
	<script>
		var table;

		(function($) {
			"use strict";

			table = $('#table__thematics').DataTable({
				"columns": [
					null,
					null,
					{ "orderable": false }
				],
			});
		})(jQuery);
	</script>
@endpush

@section('after-content')
	@include('bko.components.modals.delete', [
		'title' => "Suppression d'une thématique",
		'question' => "Êtes-vous sûr de vouloir supprimer cette thématique ?",
		'action' => 'Bko\ThematicController@destroy',
	])
@endsection