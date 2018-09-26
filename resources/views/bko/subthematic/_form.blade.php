<form action="{{ $options['url'] }}" method="post" {{ empty($modal) ? '' : 'id=form__'.$modal.'' }}>
    {{ method_field($options['method']) }}
    {{ csrf_field() }}

    <div class="form-group">
        <label for="parent_id">Thématique*</label>
        <div class="input-group">
            <select name="parent_id" id="parent_id{{ empty($modal) ? '' : '__'.$modal }}" class="form-control select2-input" style="width: 100%;">
                <option></option>
                @if(!empty($thematic->parent_id))
                    <option value="{{ $thematic->parent_id }}" selected>{{ $thematic->parent->name }}</option>
                @endif
            </select>

            @if(empty($modal))
                <span class="input-group-btn">
                    <button class="btn btn-default" type="button" data-toggle="modal" data-target="#modalNewThematic"><i class="fa fa-plus" aria-hidden="true"></i></button>
                </span>
            @endif
        </div>
    </div>
    <div class="form-group">
        <label for="name">Nom*</label>
        <input type="text" class="form-control" name="name" id="name{{ empty($modal) ? '' : '__'.$modal }}" value="{{ old('name', $thematic->name) }}">
    </div>
    <div class="form-group">
        <label for="description">Description</label>
        <textarea class="form-control"
                  rows="3"
                  name="description"
                  id="description{{ empty($modal) ? '' : '__'.$modal }}">{{ old('description', $thematic->description) }}</textarea>
    </div>

    @if(empty($modal))
        <button type="submit" class="btn btn-primary">Enregistrer</button>
    @endif
</form>

@push('inline-script')
    <script>
        (function ($) {
            "use strict";

            $('#parent_id{{ empty($modal) ? '' : '__'.$modal }}').select2({
                ajax: window.utils.select2__ajaxOptions('{{ route('bko.thematic.select2') }}')
            })

            $('#save__modalNewThematic').on('click', function () {
                window.utils.saveNewItem('modalNewThematic', '{{ action('Bko\ThematicController@store') }}', 'parent_id');
            });

            $('#modalNewThematic').on('hidden.bs.modal', function (e) {
                var _this = $(this);
                _this.find('input[type="text"], textarea').val('');
                _this.find('input[type="radio"], input[type="checkbox"]').prop('checked', false);
            });
        })(jQuery);
    </script>
@endpush

@component('bko.components.modals._default')
    @slot('id', 'modalNewThematic')
    @slot('title', "Ajout d'une thématique")
    @slot('slot')
        @include('bko.components.forms._default', [
            'model' => new \App\Thematic(),
            'options' => [ 'method' => 'POST', 'url' => '#' ],
            'modal' => 'modalNewThematic',
        ])
    @endslot
    @slot('footer')
        <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
        <button type="button" class="btn btn-primary" id="save__modalNewThematic">Ajouter</button>
    @endslot
@endcomponent