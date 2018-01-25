@extends('layouts.app')

@section('meta_title', "Contact")

@section('breadcrumb')
	<li>
		<span>Contact</span>
	</li>
@endsection

@section('content')
	<div class="page-content page-dispositifs">
		<h2>Contact</h2>

		<form action="{{ route('front.contact.store') }}" method="post" class="form-contact">
			{{ csrf_field() }}
			@if($errors->any())
				<div class="alert alert-danger">
					@foreach($errors->all() as $error)
						<p>{{ $error }}</p>
					@endforeach
				</div>
			@endif
			@if(Session::has('success'))
				<div class="alert alert-success">
					{{ session('success') }}
				</div>
			@endif
			<input name="name" placeholder="Votre nom" type="text" tabindex="1" required autofocus value="{{ old('name') }}">
			<input name="email" placeholder="Votre adresse e-mail" type="email" tabindex="2" required value="{{ old('email') }}">
			<input name="subject" placeholder="L'objet de votre message" type="text" tabindex="3" required value="{{ old('subject') }}">
			<textarea name="message" placeholder="Ecrivez votre message ici..." tabindex="4" required>{{ old('message') }}</textarea>
			<button name="submit" type="submit" id="contact-submit">Envoyer votre message</button>
		</form>
	</div>
@endsection