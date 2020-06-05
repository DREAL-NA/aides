@component('bko.components.modals._default')
    @slot('id', 'modalUnpublishItem')
    @slot('title', $title)
    @slot('slot')
        <form>
            {{ csrf_field() }}
            <input type="hidden" id="unpublishItem__id" value="">
            <input type="hidden" id="unpublishItem__refresh" value="">
            <input type="hidden" id="unpublishItem__url" value="{{ action($action, '__ID__') }}">
            <p>{!! $question !!}</p>
        </form>
    @endslot
    @slot('footer')
        <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
        <button type="button" class="btn btn-primary" id="publish__modalUnpublishItem">Dépublier</button>
    @endslot
@endcomponent

@push('inline-script')
    <script>
        (function ($) {
            "use strict";

            const unpublish = (modalId, url, id, callback) => {
                const modal = $('#' + modalId);
                $.post({
                    url,
                    data: {
                        id,
                        "_token": "{{ csrf_token() }}"
                    },
                    success: () => {
                        modal.modal('hide')
                        if (callback) {
                            callback()
                        }
                    },
                    error: (err) => {
                        console.error(err)
                    }
                })
            }

            $('#modalUnpublishItem').on('show.bs.modal', function (event) {
                var id = $(event.relatedTarget).data('id');
                const refresh = $(event.relatedTarget).data('refresh'); 
                $(this).find('#unpublishItem__refresh').val(refresh);
                $(this).find('#unpublishItem__id').val(id);
            });

            $('#publish__modalUnpublishItem').on('click', function () {
                var url = $('#unpublishItem__url').val();
                var id = parseInt($('#unpublishItem__id').val());
                const refresh = JSON.parse($('#unpublishItem__refresh').val());

                if (isNaN(id)) {
                    return id;
                }

                url = url.replace('__ID__', id);

                var callback = () => {
                };
                if (typeof table != 'undefined') {
                    callback = () => {
                        if (refresh) {
                            table
                                .row($('.publishItemBtn[data-id="' + id + '"]').parents('tr'))
                                .remove()
                                .draw();
                        } else {
                            window.location.reload();
                        }
                    };
                }

                unpublish('modalUnpublishItem', url, id, callback);
            });
        })(jQuery);
    </script>
@endpush