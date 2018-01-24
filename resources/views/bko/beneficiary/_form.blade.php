<form action="{{ $options['url'] }}" method="post" {{ empty($modal) ? '' : 'id=form__'.$modal.'' }}>
	{{ method_field($options['method']) }}
	{{ csrf_field() }}
	
	<div class="form-group">
		<label for="name">Type*</label>
		<div class="radios">
			@foreach(\App\Beneficiary::types() as $key => $label)
				<label class="radio-inline">
					<input type="radio" name="type" id="type_{{ $key }}" value="{{ $key }}" {{ !empty(old('type', $model->type)) && old('type', $model->type) == $key ? 'checked="checked"' : '' }}> {{ $label }}
				</label>
			@endforeach
		</div>
	</div>
	<div class="form-group">
		<label for="name">Nom</label>
		<input type="text" class="form-control" name="name" id="name{{ empty($modal) ? '' : '__'.$modal }}" value="{{ old('name', $model->name) }}">
	</div>
	<div class="form-group">
		<label for="description">Description</label>
		<textarea class="form-control" rows="3" name="description" id="description{{ empty($modal) ? '' : '__'.$modal }}">{{ old('description', $model->description) }}</textarea>
	</div>

	@if(empty($modal))
		<button type="submit" class="btn btn-primary">Enregistrer</button>
	@endif
</form>