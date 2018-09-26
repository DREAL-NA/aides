@extends('layouts.bko')

@section('heading')
    <div class="heading-with-actions">
        <div class="title">Liste des abonnés à la newsletter</div>
        {{--<div class="actions">--}}
        {{--<a href="{{ route('export.csv', ['table' => 'newsletter']) }}" data-tooltip="tooltip" title="Exporter en CSV">--}}
        {{--<i class="fa fa-file-text-o" aria-hidden="true"></i>--}}
        {{--</a>--}}
        {{--</div>--}}
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <table class="table table-striped table-hover table-condensed" id="table__subscribers">
                <thead>
                <tr>
                    <th>E-mail</th>
                    <th>Prénom</th>
                    <th>Nom</th>
                    <th>État</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($subscribers as $subscriber)
                    <tr>
                        <td>{{ $subscriber->email }}</td>
                        <td>{{ $subscriber->firstname }}</td>
                        <td>{{ $subscriber->lastname }}</td>
                        <td>{{ __("messages.subscribers.{$subscriber->status}") }}</td>
                        <td class="text-right col-actions" style="width: 150px;">
                            @php($route = $subscriber->isSubscribed() ? 'bko.subscriber.unsubscribe' : 'bko.subscriber.subscribe')

                            <a data-href="{{ route($route, $subscriber) }}" class="manageSubscription">{{ __("messages.subscribers.actions.{$subscriber->status}") }}</a>

                            <a href="{{ route('bko.subscriber.edit', $subscriber) }}"
                               data-tooltip="tooltip" title="Modifier">
                                <i class="fa fa-pencil" aria-hidden="true"></i>
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

        (function ($) {
            "use strict";

            table = $('#table__subscribers').DataTable({
                "pageLength": 50,
                "columns": [
                    {type: 'natural'},
                    {type: 'natural'},
                    {type: 'natural'},
                    {type: 'natural'},
                    {"orderable": false}
                ],
            });

            $('#table__subscribers').on('click', '.manageSubscription', function (e) {
                e.preventDefault();

                let _thisAction = $(this);
                let row = _thisAction.parents('tr')[0];
                let rowData = table.row(row).data();
                let links = _thisAction.parents('td').clone();

                _thisAction.parents('.col-actions').html('<i class="fa fa-spinner fa-pulse fa-fw text-primary"></i>');

                $.ajax({
                    url: $(this).data('href'),
                    method: 'post',
                    data: {},
                    success: function (data) {
                        links.find('.manageSubscription').attr('data-href', data.subscribeAction.url).html(data.subscribeAction.text)

                        rowData[0] = data.email;
                        rowData[1] = data.firstname;
                        rowData[2] = data.lastname;
                        rowData[3] = data.status;
                        rowData[4] = links[0].innerHTML;

                        table.row(row).data(rowData).draw();
                    },
                    error: function (data, json) {
                        console.log('Something went wrong. Please contact your administrator.')
                    }
                });
            });
        })(jQuery);
    </script>
@endpush