@extends('layouts.bko')

@section('heading', "Edition de l'abonné : ".$subscriber->email)
@section('menu-item-newsletter')
    <li class="menu-item active"><a href="{{ route('bko.subscriber.edit', $subscriber) }}">Edition de {{ $subscriber->email }}</a></li>
@endsection

@section('content')
    <div class="alert alert-info">
        <p><b>Attention !</b> La modification d'un abonné le ré-abonnera dans la liste Mailchimp.</p>
    </div>

    @include('bko.newsletter.subscriber._form', [
		'model' => $subscriber,
		'options' => [ 'method' => 'PUT', 'url' => action('Bko\NewsletterSubscriberController@update', $subscriber) ]
	])
@endsection