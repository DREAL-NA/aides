@extends('layouts.bko')

@section('heading', "Ajout d'un bénéficiaire")

@section('content')
	@include('bko.beneficiary._form', [
		'model' => $beneficiary,
		'options' => [ 'method' => 'POST', 'url' => action('Bko\BeneficiaryController@store') ]
	])
@endsection