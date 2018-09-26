<form action="{{ $options['url'] }}" method="post" {{ empty($modal) ? '' : 'id=form__'.$modal.'' }}>
    {{ method_field($options['method']) }}
    {{ csrf_field() }}

    <div class="form-group">
        <label for="name">E-mail</label>
        <input type="email"
               class="form-control"
               {{ !empty($model->id) ? 'readonly="readonly"' : '' }}
               name="email"
               id="email{{ empty($modal) ? '' : '__'.$modal }}"
               value="{{ old('email', $model->email) }}">
    </div>
    <div class="form-group">
        <label for="firstname">Prénom</label>
        <input type="text" class="form-control" name="firstname" id="firstname{{ empty($modal) ? '' : '__'.$modal }}" value="{{ old('firstname', $model->firstname) }}">
    </div>
    <div class="form-group">
        <label for="lastname">Nom</label>
        <input type="text" class="form-control" name="lastname" id="lastname{{ empty($modal) ? '' : '__'.$modal }}" value="{{ old('lastname', $model->lastname) }}">
    </div>

    @if(empty($modal))
        <button type="submit" class="btn btn-primary">Enregistrer</button>
    @endif
</form>