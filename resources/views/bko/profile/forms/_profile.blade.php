<form action="{{ action('Bko\ProfileController@update') }}" method="post">
    @csrf

    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
        <label for="name">Votre nom</label>
        <input type="text" class="form-control" name="name" id="name" value="{{ old('name', $user->name) }}">

        @if ($errors->has('name'))
            <span class="help-block">
                <strong>{{ $errors->first('name') }}</strong>
            </span>
        @endif
    </div>

    <button type="submit" class="btn btn-primary">Enregistrer</button>
</form>