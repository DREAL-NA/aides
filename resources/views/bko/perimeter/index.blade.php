@extends('layouts.bko')

@section('heading')
    <div class="heading-with-actions">
        <div class="title">Liste des localisations</div>
        <div class="actions">
            <a href="{{ route('export.csv', ['table' => 'perimeters']) }}" data-tooltip="tooltip" title="Exporter en CSV">
                <i class="fa fa-file-text-o" aria-hidden="true"></i>
            </a>
        </div>
    </div>
@endsection

@section('content')
    <table class="table table-striped table-hover" id="table__perimeters">
        <thead>
        <tr>
            <th style="width: 200px;">Nom</th>
            <th>Description</th>
            <th style="width: 200px;">Parents associés</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($perimeters as $perimeter)
            <tr>
                <td>{{ $perimeter->name }}</td>
                <td>{!! $perimeter->description_html !!}</td>
                <td>{{ $perimeter->parents->pluck('name')->implode(', ') }}</td>
                <td class="text-right col-actions">
                    <a href="{{ route('bko.perimetre.edit', $perimeter) }}" data-tooltip="tooltip" title="Modifier"><i
                                class="fa fa-pencil" aria-hidden="true"></i></a>
                    <a href="#" class="deleteItemBtn" title="Supprimer" data-toggle="modal"
                       data-target="#modalDeleteItem" data-tooltip="tooltip" data-id="{{ $perimeter->id }}">
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

            table = $('#table__perimeters').DataTable({
                "columns": [
                    {type: 'natural'},
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
        'title' => "Suppression d'une localisation",
        'question' => "Êtes-vous sûr de vouloir supprimer cette localisation ?",
        'action' => 'Bko\PerimeterController@destroy',
    ])
@endsection