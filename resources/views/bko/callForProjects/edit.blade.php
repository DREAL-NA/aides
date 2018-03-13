@extends('layouts.bko')

@section('heading')
    <div class="heading-with-actions">
        <div class="title">Edition du dispositif : {{ $callForProjects->name }}</div>

        <div class="actions">
            <a href="{{ route('bko.call.duplicate', $callForProjects) }}" data-tooltip="tooltip" title="Dupliquer le dispositif">
                <i class="fa fa-copy" aria-hidden="true"></i>
            </a>
        </div>
    </div>
@endsection

@section('menu-item-call')
    <li class="menu-item active"><a href="{{ route('bko.call.edit', $callForProjects) }}">Edition de {{ $callForProjects->name }}</a></li>
    <li class="menu-item"><a href="{{ route('bko.call.show', $callForProjects) }}">{{ $callForProjects->name }}</a></li>
@endsection

@section('content')
    @include('bko.callForProjects._form', [
        'callForProjects' => $callForProjects,
        'options' => [ 'method' => 'PUT', 'url' => action('Bko\CallForProjectsController@update', $callForProjects) ]
    ])
@endsection