@extends('layouts.bko')

@section('heading', "Ajout d'un abonné")

@section('content')
    @include('bko.newsletter.subscriber._form', [
		'model' => $subscriber,
		'options' => [ 'method' => 'POST', 'url' => action('Bko\NewsletterSubscriberController@store') ]
	])
@endsection