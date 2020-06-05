@component('bko.components.modals._default')
    @slot('id', 'modalPublishItem')
    @slot('title', $title)
    @slot('slot')
        <form>
            @csrf
            <input type="hidden" id="publishItem__id" value="">
            <input type="hidden" id="publishItem__refresh" value="">
            <input type="hidden" id="publishItem__url" value="{{ action($action, '__ID__') }}">
            <p>{!! $question !!}</p>
        </form>
    @endslot
    @slot('footer')
        <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
        <button type="button" class="btn btn-primary" id="publish__modalPublishItem">Publier</button>
    @endslot
@endcomponent

@push('inline-script')
    <script>
        (function ($) {
            "use strict";

            const publish = (modalId, url, id, callback) => {
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

            $('#modalPublishItem').on('show.bs.modal', function (event) {
                const id = $(event.relatedTarget).data('id');
                const refresh = $(event.relatedTarget).data('refresh'); 
                $(this).find('#publishItem__refresh').val(refresh);
                $(this).find('#publishItem__id').val(id);
            });

            $('#publish__modalPublishItem').on('click', function () {
                var url = $('#publishItem__url').val();
                var id = parseInt($('#publishItem__id').val());
                const refresh = JSON.parse($('#publishItem__refresh').val());
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

                publish('modalPublishItem', url, id, callback);
            });
        })(jQuery);
    </script>
@endpush