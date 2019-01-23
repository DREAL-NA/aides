@extends('layouts.bko')

@section('heading', "Ajout d'une aide")

@section('content')
    @include('bko.callForProjects._form', [
        'callForProjects' => $callForProjects,
        'options' => [ 'method' => 'POST', 'url' => action('Bko\CallForProjectsController@store') ],
        'perimeters' => $perimeters
    ])
@endsection