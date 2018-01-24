<div class="filters-dispositifs">
	<h4>Affiner votre recherche</h4>
	<div class="filter-items">
		<div class="filter-item">
			<select class="filters-select" multiple>
				<option disabled>Thématiques</option>
				@foreach($primary_thematics as $thematic)
					<option value="{{ $thematic->name }}">{{ $thematic->name }}</option>
				@endforeach
			</select>
		</div>
		<div class="filter-item">
			<select class="filters-select" multiple>
				<option disabled>Sous-thématiques</option>
				@foreach($primary_thematics as $primary)
					@if(empty($subthematics[$primary->id]))
						@continue
					@endif
					<optgroup label="{{ $primary->name }}">
						@foreach($subthematics[$primary->id] as $thematic)
							<option value="{{ $thematic->name }}">{{ $thematic->name }}</option>
						@endforeach
					</optgroup>
				@endforeach
			</select>
		</div>
		<div class="filter-item">
			<select class="filters-select" multiple>
				<option disabled>Porteurs du dispositif</option>
				@foreach($project_holders as $project_holder)
					<option value="{{ $project_holder->name }}">{{ $project_holder->name }}</option>
				@endforeach
			</select>
		</div>
		<div class="filter-item">
			<select class="filters-select" multiple>
				<option disabled>Périmètres</option>
				@foreach($perimeters as $perimeter)
					<option value="{{ $perimeter->id }}">{{ $perimeter->name }}</option>
				@endforeach
			</select>
		</div>
		<div class="filter-item">
			<select class="filters-select" multiple>
				<option disabled>Bénéficiaires</option>
				@foreach(\App\Beneficiary::types() as $type)
					<option value="{{ $type }}">{{ $type }}</option>
				@endforeach
			</select>
		</div>
	</div>
</div>