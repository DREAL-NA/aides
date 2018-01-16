@extends('layouts.bko')

@section('heading', "Liste des sous-thématiques")

@section('content')
	<table class="table table-striped">
		<thead>
			<tr>
				<th>Nom</th>
				<th>Thématique</th>
				<th>Description</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			@foreach($thematics as $thematic)
				<tr>
					<td>{{ $thematic->name }}</td>
					<td>{{ is_null($thematic->parent) ? '' : $thematic->parent->name }}</td>
					<td>{{ $thematic->description }}</td>
					<td class="text-right">
						<a href="{{ route('bko.subthematic.edit', $thematic) }}" title="Modifier"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
@endsection