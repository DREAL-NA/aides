<form action="{{ action('Bko\ProfileController@updatePassword') }}" method="post">
    @csrf

    <div class="form-group{{ $errors->has('old_password') ? ' has-error' : '' }}">
        <label for="old_password">Mot de passe actuel</label>
        <input id="old_password" type="password" class="form-control" name="old_password" required>

        @if ($errors->has('old_password'))
            <span class="help-block">
                <strong>{{ $errors->first('old_password') }}</strong>
            </span>
        @endif
    </div>

    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
        <label for="password">Nouveau mot de passe</label>
        <input id="password" type="password" class="form-control" name="password" required>

        @if ($errors->has('password'))
            <span class="help-block">
                <strong>{{ $errors->first('password') }}</strong>
            </span>
        @endif
    </div>

    <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
        <label for="password-confirm">Confirmer le nouveau mot de passe</label>
        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>

        @if ($errors->has('password_confirmation'))
            <span class="help-block">
                <strong>{{ $errors->first('password_confirmation') }}</strong>
            </span>
        @endif
    </div>

    <button type="submit" class="btn btn-primary">Enregistrer</button>
</form>