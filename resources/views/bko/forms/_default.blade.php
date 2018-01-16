<form action="{{ $options['url'] }}" method="post">
	{{ method_field($options['method']) }}
	{{ csrf_field() }}
	
	<div class="form-group">
		<label for="name">Nom</label>
		<input type="text" class="form-control" name="name" id="name" value="{{ old('name', $model->name) }}">
	</div>
	<div class="form-group">
		<label for="description">Description</label>
		<textarea class="form-control" rows="3" name="description" id="description">{{ old('description', $model->description) }}</textarea>
	</div>

	<button type="submit" class="btn btn-primary">Enregistrer</button>
</form>