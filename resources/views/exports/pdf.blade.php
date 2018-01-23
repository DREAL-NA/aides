<!DOCTYPE html>
<html>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<style>
		* { margin:0; padding:0 }
		th, td, div { margin: 0; padding: 5px }
		html { margin: 10px }

		.page-break {
			page-break-after: always;
		}

		table {
			border-collapse: collapse;
		}

		table tr.selected td {
			background-color: #5CDB95;
			color: #ffffff;
		}

		th, td {
			border: thin solid #333;
			width: auto !important;
		}
		h2 {
			margin-bottom: 10px;
		}
	</style>
	<body>
		@foreach($callsForProjects as $thematic_id => $items)
			@php($callsOfTheWeek = App\CallForProjects::filterCallsOfTheWeek($items)->pluck('id'))
			@php($thematic = $items->first()->thematic)

			<h2>{{ $thematic->name }}</h2>
			@include('exports._table', [ 'callsForProjects' => $items, 'callsOfTheWeek' => $callsOfTheWeek ])

			@if(! $loop->last)
				<div class="page-break"></div>
			@endif
		@endforeach
	</body>
</html>