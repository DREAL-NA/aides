@extends('layouts.bko')

@section('heading')
    <div class="heading-with-actions">
        <div class="title">Liste des sites de recensement</div>
        <div class="actions">
            <a href="{{ route('bko.export.table', ['table' => 'websites']) }}" data-tooltip="tooltip" title="Exporter en CSV">
                <i class="fa fa-file-excel-o" aria-hidden="true"></i>
            </a>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="row filters-table">
                {{--<div class="form-group">--}}
                {{--<label for="filter__organizationType">Organisations</label>--}}
                {{--<select id="filter__organizationType" class="form-control select2-filter" multiple="multiple">--}}
                {{--<option></option>--}}
                {{--@foreach($organizationTypes as $organizationType)--}}
                {{--<option value="{{ $organizationType->name }}">{{ $organizationType->name }}</option>--}}
                {{--@endforeach--}}
                {{--</select>--}}
                {{--</div>--}}
                <div class="form-group">
                    <label for="filter__perimeter">Périmètre</label>
                    <select id="filter__perimeter" class="form-control select2-filter" multiple="multiple">
                        <option></option>
                        @foreach($perimeters as $perimeter)
                            <option value="{{ $perimeter->name }}">{{ $perimeter->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <table class="table table-striped table-hover table-condensed" id="table__websites">
                <thead>
                <tr>
                    {{--<th>Organisation</th>--}}
                    <th>Logo</th>
                    <th>Nom</th>
                    <th>Thèmes</th>
                    <th>Périmètre</th>
                    <th>Adresse internet</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($websites as $website)
                    <tr>
                        {{--                        <td>{{ $website->organizationType->name }}</td>--}}
                        <td>
                            @if(!empty($website->getFirstMedia(\App\Website::MEDIA_COLLECTION)))
                                <img src="{{ $website->getFirstMedia(\App\Website::MEDIA_COLLECTION)->getUrl() }}" alt="logo"
                                     class="img-responsive" style="width: 150px; margin-bottom: 15px;">
                            @endif
                        </td>
                        <td>{{ $website->name }}</td>
                        <td>{!! $website->themes_html !!}</td>
                        <td>{!! $website->perimeters->implode('name', ', ') !!}</td>
                        <td>
                            @if(!empty($website->website_url))
                                <a href="{{ $website->website_url }}" target="_blank">Lien vers le site</a>
                            @endif
                        </td>
                        <td class="text-right col-actions">
                            <a href="{{ route('bko.site.show', $website) }}" data-tooltip="tooltip"
                               title="Voir la fiche"><i class="fa fa-eye" aria-hidden="true"></i></a>
                            <a href="{{ route('bko.site.edit', $website) }}" data-tooltip="tooltip" title="Modifier"><i
                                        class="fa fa-pencil" aria-hidden="true"></i></a>
                            <a href="#" class="deleteItemBtn" title="Supprimer" data-toggle="modal"
                               data-target="#modalDeleteItem" data-tooltip="tooltip" data-id="{{ $website->id }}">
                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('inline-script')
    <script>
        var table;

        function filterResults() {
            // window.utils.searchFilterArrayValues($('#filter__organizationType').val(), 0);
            window.utils.searchFilterArrayValues($('#filter__perimeter').val(), 2);
            table.draw();
        }

        (function ($) {
            "use strict";

            table = $('#table__websites').DataTable({
                "order": [[1, "asc"]],
                "columns": [
                    // {type: 'natural'},
                    {"orderable": false},
                    {type: 'natural'},
                    {type: 'natural'},
                    {type: 'natural'},
                    {type: 'natural'},
                    {"orderable": false}
                ],
            });

            $('.select2-filter')
                .select2()
                .on('change', function () {
                    filterResults();
                });
        })(jQuery);
    </script>
@endpush

@section('after-content')
    @include('bko.components.modals.delete', [
        'title' => "Suppression d'un site",
        'question' => "Êtes-vous sûr de vouloir supprimer ce site ?",
        'action' => 'Bko\WebsiteController@destroy',
    ])
@endsection