@extends('layouts.bko')

@section('heading', "Edition de l'utilisateur : ".$user->name)

@section('menu-item-user')
    <li class="menu-item active"><a href="{{ route('bko.utilisateur.edit', $user) }}">Edition de {{ $user->name }}</a></li>
@endsection

@section('content')
    @include('bko.user._form', [
        'model' => $user,
        'options' => [ 'method' => 'PUT', 'url' => action('Bko\UserController@update', $user) ]
    ])
@endsection