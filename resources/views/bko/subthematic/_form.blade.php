<form action="{{ $options['url'] }}" method="post">
	{{ method_field($options['method']) }}
	{{ csrf_field() }}

	<div class="form-group">
		<label for="parent_id">Thématique*</label>
		<select name="parent_id" id="parent_id" class="form-control select2-input">
			@foreach($primary_thematics as $item)
				<option value="{{ $item->id }}" {{ $item->id == $thematic->parent_id ? 'selected="selected"' : '' }}>{{ $item->name }}</option>
			@endforeach
		</select>
	</div>
	<div class="form-group">
		<label for="name">Nom*</label>
		<input type="text" class="form-control" name="name" id="name" value="{{ old('name', $thematic->name) }}">
	</div>
	<div class="form-group">
		<label for="description">Description</label>
		<textarea class="form-control" rows="3" name="description" id="description">{{ old('description', $thematic->description) }}</textarea>
	</div>

	<button type="submit" class="btn btn-primary">Enregistrer</button>
</form>