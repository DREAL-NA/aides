@extends('layouts.bko')

@section('heading')
    <div class="heading-with-actions">
        <div class="title">{{ $title }}</div>
        @if(!$closed && !$callsForProjects->isEmpty())
            <div class="actions">
                <a href="{{ route('export.xlsx') }}" data-tooltip="tooltip" title="Exporter en Excel">
                    <i class="fa fa-file-excel-o" aria-hidden="true"></i>
                </a>
                <a href="{{ route('export.csv', ['table' => 'dispositifs']) }}" data-tooltip="tooltip" title="Exporter en CSV">
                    <i class="fa fa-file-text-o" aria-hidden="true"></i>
                </a>
                <a href="{{ route('export.pdf') }}" data-tooltip="tooltip" title="Exporter en PDF">
                    <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                </a>
            </div>
        @endif
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="row filters-table">
                <div class="form-group">
                    <label for="filter__thematic">Thématique</label>
                    <select id="filter__thematic" class="form-control select2-filter" multiple="multiple">
                        <option></option>
                        @foreach($primary_thematics as $thematic)
                            <option value="{{ $thematic->id }}">{{ $thematic->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="filter__subthematic">Sous-thématique</label>
                    <select id="filter__subthematic" class="form-control select2-filter" multiple="multiple">
                        <option></option>
                        @foreach($primary_thematics as $primary)
                            @if(empty($subthematics[$primary->id]))
                                @continue
                            @endif
                            <optgroup label="{{ $primary->name }}" data-id="{{ $primary->id }}">
                                @foreach($subthematics[$primary->id] as $thematic)
                                    <option value="{{ $thematic->id }}">{{ $thematic->name }}</option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="filter__projectHolder">Porteur du dispositif</label>
                    <select id="filter__projectHolder" class="form-control select2-filter" multiple="multiple">
                        <option></option>
                        @foreach($project_holders as $project_holder)
                            <option value="{{ $project_holder->id }}">{{ $project_holder->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="filter__perimeter">Périmètre</label>
                    <select id="filter__perimeter" class="form-control select2-filter" multiple="multiple">
                        <option></option>
                        @foreach($perimeters as $perimeter)
                            <option value="{{ $perimeter->id }}">{{ $perimeter->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="filter__beneficiary">Bénéficiaire</label>
                    <select id="filter__beneficiary" class="form-control select2-filter" multiple="multiple">
                        <option></option>
                        @foreach(\App\Beneficiary::types() as $type)
                            <option value="{{ $type }}">{{ $type }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <table class="table table-striped table-hover table-condensed" id="table__callsForProjects">
                <thead>
                <tr>
                    <th></th>
                    <th>Thématique</th>
                    <th></th>
                    <th>Sous-thématique</th>
                    <th>Intitulé</th>
                    <th>Date de clôture</th>
                    <th></th>
                    <th>Porteurs du dispositif</th>
                    <th></th>
                    <th>Périmètres</th>
                    <th>Objectifs</th>
                    <th></th>
                    <th>Bénéficiaires</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($callsForProjects as $callForProjects)
                    @php
                        $subthematic = empty($subthematics[$callForProjects->thematic->id]) ? null : $subthematics[$callForProjects->thematic->id]->firstWhere('id', $callForProjects->subthematic_id);
                    @endphp
                    <tr class="{{ in_array($callForProjects->id, $callsOfTheWeek->toArray()) ? 'item-of-the-week' : '' }}">
                        <td>{{ $callForProjects->thematic->id }}</td>
                        <td>{{ $callForProjects->thematic->name }}</td>
                        <td>{{ empty($subthematic) ? '' : $subthematic->id }}</td>
                        <td>{{ empty($subthematic) ? '' : $subthematic->name }}</td>
                        <td>{{ $callForProjects->name }}</td>
                        <td>{{ empty($callForProjects->closing_date) ? '' : $callForProjects->closing_date->format('d/m/Y') }}</td>
                        <td>,{{ $callForProjects->projectHolders->pluck('id')->implode(',') }},</td>
                        <td>{{ $callForProjects->projectHolders->pluck('name')->implode(', ') }}</td>
                        <td>,{{ $callForProjects->perimeters->pluck('id')->implode(',') }},</td>
                        <td>{{ $callForProjects->perimeters->pluck('name')->implode(', ') }}</td>
                        <td>{{ \Illuminate\Support\Str::words($callForProjects->objectives, 50) }}</td>
                        <td>,{{ $callForProjects->beneficiaries->pluck('type_label')->unique()->implode(',') }},</td>
                        <td>{{ $callForProjects->beneficiaries->pluck('type_label')->unique()->implode(', ') }}</td>
                        <td class="text-right col-actions">
                            <a href="{{ route('bko.call.show', $callForProjects) }}" data-tooltip="tooltip"
                               title="Voir la fiche"><i class="fa fa-eye" aria-hidden="true"></i></a>
                            <a href="{{ route('bko.call.edit', $callForProjects) }}" data-tooltip="tooltip"
                               title="Modifier"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                            <a href="#" class="deleteItemBtn" title="Supprimer" data-toggle="modal"
                               data-target="#modalDeleteItem" data-tooltip="tooltip"
                               data-id="{{ $callForProjects->id }}">
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
            window.utils.searchFilterArrayValues($('#filter__thematic').val(), 0, true);
            window.utils.searchFilterArrayValues($('#filter__subthematic').val(), 2, true);
            window.utils.searchFilterArrayValues($('#filter__projectHolder').val(), 6);
            window.utils.searchFilterArrayValues($('#filter__perimeter').val(), 8);
            window.utils.searchFilterArrayValues($('#filter__beneficiary').val(), 11);

            table.draw();
        }

        (function ($) {
            "use strict";

            table = $('#table__callsForProjects').DataTable({
                "columns": [
                    {
                        "targets": [1],
                        "visible": false,
                        "searchable": true
                    },
                    null,
                    {
                        "targets": [3],
                        "visible": false,
                        "searchable": true
                    },
                    null,
                    null,
                    {"type": "date-uk"},
                    {
                        "targets": [7],
                        "visible": false,
                        "searchable": true
                    },
                    null,
                    {
                        "targets": [9],
                        "visible": false,
                        "searchable": true
                    },
                    null,
                    null,
                    {
                        "targets": [12],
                        "visible": false,
                        "searchable": true
                    },
                    null,
                    {"orderable": false}
                ],
            });

            $('.select2-filter')
                .select2()
                .on('change', function () {

                    if ($(this).attr('id') == 'filter__thematic') {
                        var thematics = $(this).val();

                        if (thematics.length > 0) {
                            $('#filter__subthematic optgroup').hide();
                            $('#filter__subthematic option').attr('disabled', true);

                            for (let thematic of thematics) {
                                $('#filter__subthematic optgroup[data-id="' + thematic + '"]').show();
                                $('#filter__subthematic optgroup[data-id="' + thematic + '"] option').attr('disabled', false);
                            }
                        } else {
                            $('#filter__subthematic optgroup').show();
                            $('#filter__subthematic option').attr('disabled', false);
                        }

                        $('#filter__subthematic').select2();
                    }

                    filterResults();
                });
        })(jQuery);
    </script>
@endpush

@section('after-content')
    @include('bko.components.modals.delete', [
        'title' => "Suppression d'un dispositif",
        'question' => "Êtes-vous sûr de vouloir supprimer ce dispositif ?",
        'action' => 'Bko\CallForProjectsController@destroy',
    ])
@endsection