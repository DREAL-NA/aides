<form action="{{ $options['url'] }}" method="post" {{ empty($modal) ? '' : 'id=form__'.$modal.'' }}>
    {{ method_field($options['method']) }}
    {{ csrf_field() }}

    <div class="form-group">
        <label for="name">Nom*</label>
        <input type="text" class="form-control" name="name" id="name{{ empty($modal) ? '' : '__'.$modal }}" value="{{ old('name', $model->name) }}">
    </div>
    <div class="form-group">
        <label for="description">Description</label>
        <textarea class="form-control" rows="3" name="description" id="description{{ empty($modal) ? '' : '__'.$modal }}">{{ old('description', $model->description) }}</textarea>
    </div>

    <div class="form-group">
        <label for="perimeter_parents{{ empty($modal) ? '' : '__'.$modal }}">Localisations globales associées au menu "Quels sont mes aides pour les territoires ?"</label>
        <select name="parents[]" id="perimeter_parents{{ empty($modal) ? '' : '__'.$modal }}" class="form-control select2-allow-clear" multiple>
            <option></option>
            @foreach($parents as $parent)
                <option value="{{ $parent->id }}"
                        {{ $model->parents->contains('id', $parent->id) || (!empty(old('parents')) && in_array($parent->id, old('parents'))) ? 'selected' : '' }}
                >{{ $parent->name }}</option>
            @endforeach
        </select>
    </div>

    @if(empty($modal))
        <button type="submit" class="btn btn-primary">Enregistrer</button>
    @endif
</form>