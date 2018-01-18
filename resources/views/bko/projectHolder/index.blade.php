@extends('layouts.bko')

@section('heading', "Liste des porteurs des dispositifs")

@section('content')
	<table class="table table-striped table-hover" id="table__projectHolders">
		<thead>
			<tr>
				<th>Nom</th>
				<th>Description</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			@foreach($projectHolders as $projectHolder)
				<tr>
					<td>{{ $projectHolder->name }}</td>
					<td>{!! $projectHolder->description_html !!}</td>
					<td class="text-right col-actions">
						<a href="{{ route('bko.porteur-dispositif.edit', $projectHolder) }}" title="Modifier"><i class="fa fa-pencil" aria-hidden="true"></i></a>
						<a href="#" class="deleteItemBtn" title="Supprimer" data-toggle="modal" data-target="#modalDeleteItem" data-id="{{ $projectHolder->id }}">
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

			table = $('#table__projectHolders').DataTable({
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
		'title' => "Suppression d'un porteur du dispositif",
		'question' => "Êtes-vous sûr de vouloir supprimer ce porteur du dispositif ?",
		'action' => 'Bko\ProjectHolderController@destroy',
	])
@endsection