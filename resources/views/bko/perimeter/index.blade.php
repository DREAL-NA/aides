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
					<td>{{ $perimeter->description }}</td>
					<td class="text-right">
						<a href="{{ route('bko.perimetre.edit', $perimeter) }}" title="Modifier"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
@endsection

@push('inline-script')
	<script>
		(function($) {
			"use strict";

			$('#table__perimeters').DataTable({
				"columns": [
					null,
					null,
					{ "orderable": false }
				],
			});
		})(jQuery);
	</script>
@endpush