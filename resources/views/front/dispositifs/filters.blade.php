<div class="filters-dispositifs">
	<h4>Affiner votre recherche</h4>
	<form action="{{ route('front.dispositifs') }}" class="form-filters" method="get">
		<div class="filter-items">
			<div class="filter-item">
				<select name="{{ \App\Thematic::URI_NAME_THEMATIC }}[]" class="filters-select" multiple>
					<option disabled>Thématiques</option>
					@foreach($primary_thematics as $thematic)
						@php($selected = (!empty(request()->get(\App\Thematic::URI_NAME_THEMATIC)) && in_array($thematic->id, request()->get(\App\Thematic::URI_NAME_THEMATIC))) ?: false)
						<option value="{{ $thematic->id }}" {{ $selected ? 'selected="selected"' : '' }}>{{ $thematic->name }}</option>
					@endforeach
				</select>
			</div>
			<div class="filter-item">
				<select name="{{ \App\Thematic::URI_NAME_SUBTHEMATIC }}[]" class="filters-select" multiple id="filter-subthematic">
					<option disabled>Sous-thématiques</option>
					@foreach($primary_thematics as $primary)
						@if(empty($subthematics[$primary->id]))
							@continue
						@endif
						<optgroup label="{{ $primary->name }}">
							@foreach($subthematics[$primary->id] as $thematic)
								@php($selected = (!empty(request()->get(\App\Thematic::URI_NAME_SUBTHEMATIC)) && in_array($thematic->id, request()->get(\App\Thematic::URI_NAME_SUBTHEMATIC))) ?: false)
								<option value="{{ $thematic->id }}" {{ $selected ? 'selected="selected"' : '' }}>{{ $thematic->name }}</option>
							@endforeach
						</optgroup>
					@endforeach
				</select>
			</div>
			<div class="filter-item">
				<select name="{{ \App\ProjectHolder::URI_NAME }}[]" class="filters-select" multiple>
					<option disabled>Porteurs du dispositif</option>
					@foreach($project_holders as $project_holder)
						@php($selected = (!empty(request()->get(\App\ProjectHolder::URI_NAME)) && in_array($project_holder->id, request()->get(\App\ProjectHolder::URI_NAME))) ?: false)
						<option value="{{ $project_holder->id }}" {{ $selected ? 'selected="selected"' : '' }}>{{ $project_holder->name }}</option>
					@endforeach
				</select>
			</div>
			<div class="filter-item">
				<select name="{{ \App\Perimeter::URI_NAME }}[]" class="filters-select" multiple>
					<option disabled>Périmètres</option>
					@foreach($perimeters as $perimeter)
						@php($selected = (!empty(request()->get(\App\Perimeter::URI_NAME)) && in_array($perimeter->id, request()->get(\App\Perimeter::URI_NAME))) ?: false)
						<option value="{{ $perimeter->id }}" {{ $selected ? 'selected="selected"' : '' }}>{{ $perimeter->name }}</option>
					@endforeach
				</select>
			</div>
			<div class="filter-item">
				<select name="{{ \App\Beneficiary::URI_NAME }}[]" class="filters-select" multiple>
					<option disabled>Bénéficiaires</option>
					@foreach(\App\Beneficiary::types() as $key => $type)
						@php($selected = (!empty(request()->get(\App\Beneficiary::URI_NAME)) && in_array($key, request()->get(\App\Beneficiary::URI_NAME))) ?: false)
						<option value="{{ $key }}" {{ $selected ? 'selected="selected"' : '' }}>{{ $type }}</option>
					@endforeach
				</select>
			</div>
		</div>
		<div class="form-action">
			<button type="button" class="reset-filters">Réinitialiser les filtres</button>
			<button type="button" class="submit-filters">Rechercher</button>
		</div>
	</form>
</div>