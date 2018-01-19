@extends('layouts.app')

@section('content')
	@if(!empty($countCallsForProjects))
		<div class="count-dispositifs-wrapper">{!! trans_choice('messages.home.count', $countCallsForProjects) !!}</div>
	@endif
@endsection