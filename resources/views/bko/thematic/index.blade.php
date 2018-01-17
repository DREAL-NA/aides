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
					<td class="text-right">
						<a href="{{ route('bko.thematic.edit', $thematic) }}" title="Modifier"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
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

			$('#table__thematics').DataTable({
				"columns": [
					null,
					null,
					{ "orderable": false }
				],
			});
		})(jQuery);
	</script>
@endpush