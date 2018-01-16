<form action="{{ $options['url'] }}" method="post">
	{{ method_field($options['method']) }}
	{{ csrf_field() }}

	<div class="form-group">
		<label for="thematic_id">Thématique</label>
		<select name="thematic_id" id="thematic_id" class="form-control select2-input">
			<option></option>
			@foreach($primary_thematics as $item)
				<option value="{{ $item->id }}">{{ $item->name }}</option>
			@endforeach
		</select>
	</div>
	<div class="form-group">
		<label for="subthematic_id">Sous-thématique</label>
		<select name="subthematic_id" id="subthematic_id" class="form-control select2-input"></select>
	</div>
	<div class="form-group">
		<label for="name">Intitulé</label>
		<input type="text" class="form-control" name="name" id="name" value="{{ old('name', $callForProjects->name) }}">
	</div>
	<div class="form-group">
		<label for="closing_date">Date de clotûre</label>
		<input type="text" class="form-control" name="closing_date" id="closing_date" value="{{ old('closing_date', $callForProjects->closing_date) }}">
	</div>
	<div class="form-group">
		<label for="description">Description</label>
		<textarea class="form-control" rows="3" name="description" id="description">{{ old('description', $callForProjects->description) }}</textarea>
	</div>

	<button type="submit" class="btn btn-primary">Enregistrer</button>
</form>

@section('inline-script')
	<script>
		var $_subthematics_data = {!! $subthematics->toJson() !!};

		function initSubthematicData() {
			var thematic_id = $('#thematic_id').val();

			var custom_data = [];
			if($_subthematics_data[thematic_id] !== undefined) {
				custom_data = $.map($_subthematics_data[thematic_id], function (obj) {
					return {
						id: obj.id,
						text: obj.name,
					}
				});
			}

			$('#subthematic_id').empty().select2({ data: custom_data });
		}

		(function($) {
			"use strict";

			$('#thematic_id').on('change', function() {
				initSubthematicData();
			});
		})(jQuery);
	</script>
@endsection