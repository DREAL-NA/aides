@extends('layouts.bko')

@section('heading', "Edition du périmètre : ".$perimeter->name)
@section('menu-item-perimeter')
    <li class="menu-item active"><a href="{{ route('bko.perimetre.edit', $perimeter) }}">Edition de {{ $perimeter->name }}</a></li>
@endsection

@section('content')
    @include('bko.perimeter._form', [
        'model' => $perimeter,
        'options' => [ 'method' => 'PUT', 'url' => action('Bko\PerimeterController@update', $perimeter) ]
    ])
@endsection