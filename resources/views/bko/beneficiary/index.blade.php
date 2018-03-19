@extends('layouts.bko')

@section('heading')
    <div class="heading-with-actions">
        <div class="title">Liste des bénéficiaires</div>
        <div class="actions">
            <a href="{{ route('bko.export.table', ['table' => 'beneficiaries']) }}" data-tooltip="tooltip" title="Exporter en CSV">
                <i class="fa fa-file-excel-o" aria-hidden="true"></i>
            </a>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="row filters-table">
                <div class="form-group">
                    <label for="filter__type">Type</label>
                    <select id="filter__type" class="form-control select2-filter">
                        <option></option>
                        @foreach($types as $key => $type)
                            <option value="{{ $type }}">{{ $type }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <table class="table table-striped table-hover" id="table__beneficiaries">
                <thead>
                <tr>
                    <th>Type</th>
                    <th>Nom</th>
                    <th>Description</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($beneficiaries as $beneficiary)
                    <tr>
                        <td>{{ $types[$beneficiary->type] }}</td>
                        <td>{{ $beneficiary->name }}</td>
                        <td>{!! $beneficiary->description_html !!}</td>
                        <td class="text-right col-actions">
                            <a href="{{ route('bko.beneficiaire.edit', $beneficiary) }}" data-tooltip="tooltip"
                               title="Modifier"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                            <a href="#" class="deleteItemBtn" title="Supprimer" data-toggle="modal"
                               data-target="#modalDeleteItem" data-tooltip="tooltip" data-id="{{ $beneficiary->id }}">
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
            var filter__type = $.fn.DataTable.ext.type.search.string($.fn.dataTable.util.escapeRegex($('#filter__type').val()));

            table.columns(0).search(filter__type ? '^' + filter__type + '$' : '', true, false).draw();
        }

        (function ($) {
            "use strict";

            table = $('#table__beneficiaries').DataTable({
                "columns": [
                    {type: 'natural'},
                    {type: 'natural'},
                    {type: 'natural'},
                    {"orderable": false}
                ],
            });

            $('.select2-filter').select2({
                allowClear: true,
            }).on('select2:unselecting', function () {
                $(this).data('unselecting', true);
            }).on('select2:opening', function (e) {
                if ($(this).data('unselecting')) {
                    $(this).removeData('unselecting');
                    e.preventDefault();
                }
            }).on('change', function () {
                filterResults();
            });
        })(jQuery);
    </script>
@endpush

@section('after-content')
    @include('bko.components.modals.delete', [
        'title' => "Suppression d'un bénéficiaire",
        'question' => "Êtes-vous sûr de vouloir supprimer ce bénéficiaire ?",
        'action' => 'Bko\BeneficiaryController@destroy',
    ])
@endsection