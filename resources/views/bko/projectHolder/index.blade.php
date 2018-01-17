@extends('layouts.bko')

@section('heading', "Liste des porteurs de dispositifs")

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
					<td>{{ $projectHolder->description }}</td>
					<td class="text-right">
						<a href="{{ route('bko.porteur-dispositif.edit', $projectHolder) }}" title="Modifier"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
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

			$('#table__projectHolders').DataTable({
				"columns": [
					null,
					null,
					{ "orderable": false }
				],
			});
		})(jQuery);
	</script>
@endpush