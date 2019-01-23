@extends('layouts.bko')

@section('heading')
    <div class="heading-with-actions">
        <div class="title">Liste des financeurs des aides</div>
        <div class="actions">
            <a href="{{ route('export.csv', ['table' => 'project_holders']) }}" data-tooltip="tooltip" title="Exporter en CSV">
                <i class="fa fa-file-text-o" aria-hidden="true"></i>
            </a>
        </div>
    </div>
@endsection

@section('content')
    <table class="table table-striped table-hover" id="table__projectHolders">
        <thead>
        <tr>
            <th>Nom</th>
            <th>Description</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($projectHolders as $projectHolder)
            <tr>
                <td>{{ $projectHolder->name }}</td>
                <td>{!! $projectHolder->description_html !!}</td>
                <td class="text-right col-actions">
                    <a href="{{ route('bko.porteur-dispositif.edit', $projectHolder) }}" data-tooltip="tooltip"
                       title="Modifier"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                    <a href="#" class="deleteItemBtn" title="Supprimer" data-toggle="modal"
                       data-target="#modalDeleteItem" data-tooltip="tooltip" data-id="{{ $projectHolder->id }}">
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

            table = $('#table__projectHolders').DataTable({
                "columns": [
                    {type: 'natural'},
                    {type: 'natural'},
                    {"orderable": false}
                ],
            });
        })(jQuery);
    </script>
@endpush

@section('after-content')
    @include('bko.components.modals.delete', [
        'title' => "Suppression d'un financeur des aides",
        'question' => "Êtes-vous sûr de vouloir supprimer ce financeur des aides ?",
        'action' => 'Bko\ProjectHolderController@destroy',
    ])
@endsection