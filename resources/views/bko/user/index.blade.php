@extends('layouts.bko')

@section('heading', "Liste des utilisateurs")

@section('content')
    <table class="table table-striped table-hover" id="table__users">
        <thead>
        <tr>
            <th>Nom</th>
            <th>E-mail</th>
            <th>Date de création</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->created_at->format('d/m/Y') }}</td>
                <td class="text-right col-actions">
                    <a href="{{ route('bko.utilisateur.edit', $user) }}" data-tooltip="tooltip" title="Modifier">
                        <i class="fa fa-pencil" aria-hidden="true"></i>
                    </a>
                    <a href="#" class="deleteItemBtn" title="Supprimer" data-toggle="modal"
                       data-target="#modalDeleteItem" data-tooltip="tooltip" data-id="{{ $user->id }}">
                        <i class="fa fa-trash-o" aria-hidden="true"></i>
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection

@push('inline-script')
    <script>
        var table;

        (function ($) {
            "use strict";

            table = $('#table__users').DataTable({
                "columns": [
                    {type: 'natural'},
                    {type: 'natural'},
                    {"type": "date-uk"},
                    {"orderable": false}
                ],
            });
        })(jQuery);
    </script>
@endpush

@section('after-content')
    @include('bko.components.modals.delete', [
        'title' => "Suppression d'un périmètre",
        'question' => "Êtes-vous sûr de vouloir supprimer ce périmètre ?",
        'action' => 'Bko\PerimeterController@destroy',
    ])
@endsection