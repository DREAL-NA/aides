@component('bko.components.modals._default')
    @slot('id', 'modalDeleteItem')
    @slot('title', $title)
    @slot('slot')
        <form>
            <input type="hidden" id="deleteItem__id" value="">
            <input type="hidden" id="deleteItem__url" value="{{ action($action, '__ID__') }}">
            <p>{!! $question !!}</p>
        </form>
    @endslot
    @slot('footer')
        <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
        <button type="button" class="btn btn-danger" id="delete__modalDeleteItem">Supprimer</button>
    @endslot
@endcomponent

@push('inline-script')
    <script>
        (function ($) {
            "use strict";

            $('#modalDeleteItem').on('show.bs.modal', function (event) {
                var id = $(event.relatedTarget).data('id');
                $(this).find('#deleteItem__id').val(id);
            });

            $('#delete__modalDeleteItem').on('click', function () {
                var url = $('#deleteItem__url').val();
                var id = parseInt($('#deleteItem__id').val());

                if (isNaN(id)) {
                    return id;
                }

                url = url.replace('__ID__', id);

                var callback = () => {
                };
                if (typeof table != 'undefined') {
                    callback = () => {
                        table
                            .row($('.deleteItemBtn[data-id="' + id + '"]').parents('tr'))
                            .remove()
                            .draw();
                    };
                }

                window.utils.deleteItem('modalDeleteItem', url, id, callback);
            });
        })(jQuery);
    </script>
@endpush