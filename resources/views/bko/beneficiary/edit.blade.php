@extends('layouts.bko')

@section('heading', "Edition du bénéficiaire : ".$beneficiary->name)
@section('menu-item-beneficiary')
	<li class="menu-item active"><a href="{{ route('bko.beneficiaire.edit', $beneficiary) }}">Edition de {{ $beneficiary->name }}</a></li>
@endsection

@section('content')
	@include('bko.beneficiary._form', [
		'model' => $beneficiary,
		'options' => [ 'method' => 'PUT', 'url' => action('Bko\BeneficiaryController@update', $beneficiary) ]
	])
@endsection