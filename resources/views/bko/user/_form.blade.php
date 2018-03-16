<form action="{{ $options['url'] }}" method="post">
    {{ method_field($options['method']) }}
    {{ csrf_field() }}

    <div class="form-group">
        <label for="name">Nom*</label>
        <input type="text" class="form-control" name="name" id="name" value="{{ old('name', $model->name) }}">
    </div>
    <div class="form-group">
        <label for="email">E-mail*</label>
        <input type="email" class="form-control" name="email" id="email" value="{{ old('email', $model->email) }}">
    </div>

    <button type="submit" class="btn btn-primary">Enregistrer</button>
</form>