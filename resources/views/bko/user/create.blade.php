@extends('layouts.bko')

@section('heading', "Ajout d'un utilisateur")

@section('content')
    @include('bko.user._form', [
        'model' => $user,
        'options' => [ 'method' => 'POST', 'url' => action('Bko\UserController@store') ]
    ])
@endsection