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
					<td class="text-right">
						<a href="{{ route('bko.structure.edit', $organizationType) }}" title="Modifier"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
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

			$('#table__orgaTypes').DataTable({
				"columns": [
					null,
					null,
					{ "orderable": false }
				],
			});
		})(jQuery);
	</script>
@endpush