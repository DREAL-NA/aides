@extends('layouts.bko')

@section('heading', "Liste des structures")

@section('content')
	<table class="table table-striped table-hover" id="table__orgaTypes">
		<thead>
		<tr>
			<th>Nom</th>
			<th>Description</th>
			<th></th>
		</tr>
		</thead>
		<tbody>
		@foreach($organizationTypes as $organizationType)
			<tr>
				<td>{{ $organizationType->name }}</td>
				<td>{!! $organizationType->description_html !!}</td>
				<td class="text-right col-actions">
					<a href="{{ route('bko.structure.edit', $organizationType) }}" data-tooltip="tooltip"
					   title="Modifier"><i class="fa fa-pencil" aria-hidden="true"></i></a>
					{{--<a href="#" class="deleteItemBtn" title="Supprimer" data-toggle="modal" data-target="#modalDeleteItem" data-id="{{ $organizationType->id }}">--}}
					{{--<i class="fa fa-trash-o" aria-hidden="true"></i>--}}
					{{--</a>--}}
				</td>
			</tr>
		@endforeach
		</tbody>
	</table>
@endsection

@push('inline-script')
	<script>
		var table;

		(function ($) {
			"use strict";

			table = $('#table__orgaTypes').DataTable({
				"columns": [
					{type: 'natural'},
					{type: 'natural'},
					{"orderable": false}
				],
			});
		})(jQuery);
	</script>
@endpush

{{--@section('after-content')--}}
{{--@include('bko.components.modals.delete', [--}}
{{--'title' => "Suppression d'une structure",--}}
{{--'question' => "Êtes-vous sûr de vouloir supprimer cette structure ?",--}}
{{--'action' => 'Bko\OrganizationTypeController@destroy',--}}
{{--])--}}
{{--@endsection--}}