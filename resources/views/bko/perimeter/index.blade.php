@extends('layouts.bko')

@section('heading', "Liste des périmètres")

@section('content')
	<table class="table table-striped table-hover" id="table__perimeters">
		<thead>
			<tr>
				<th>Nom</th>
				<th>Description</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			@foreach($perimeters as $perimeter)
				<tr>
					<td>{{ $perimeter->name }}</td>
					<td>{!! $perimeter->description_html !!}</td>
					<td class="text-right col-actions">
						<a href="{{ route('bko.perimetre.edit', $perimeter) }}" title="Modifier"><i class="fa fa-pencil" aria-hidden="true"></i></a>
						<a href="#" class="deleteItemBtn" title="Supprimer" data-toggle="modal" data-target="#modalDeleteItem" data-id="{{ $perimeter->id }}">
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

			table = $('#table__perimeters').DataTable({
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
		'title' => "Suppression d'un périmètre",
		'question' => "Êtes-vous sûr de vouloir supprimer ce périmètre ?",
		'action' => 'Bko\PerimeterController@destroy',
	])
@endsection