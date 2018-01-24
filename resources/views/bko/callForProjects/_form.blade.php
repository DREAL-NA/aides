<form action="{{ $options['url'] }}" method="post">
	{{ method_field($options['method']) }}
	{{ csrf_field() }}

	@php
	$thematic_id = old('thematic_id', $callForProjects->thematic_id);
	$subthematic_id = old('subthematic_id', $callForProjects->subthematic_id);
	$project_holder_id = old('project_holder_id', $callForProjects->project_holder_id);
	$perimeter_id = old('perimeter_id', $callForProjects->perimeter_id);
	$beneficiary_id = old('beneficiary_id', $callForProjects->beneficiary_id);
	$allocation_global = old('allocation_global', $callForProjects->allocation_global);
	$allocation_per_project = old('allocation_per_project', $callForProjects->allocation_per_project);
	@endphp

	<div class="form-group">
		<label for="thematic_id">Thématique*</label>
		<select name="thematic_id" id="thematic_id" class="form-control select2-input">
			<option></option>
			@foreach($primary_thematics as $item)
				<option value="{{ $item->id }}" {{ empty($thematic_id) || $thematic_id != $item->id ? '' : 'selected="selected"' }}>{{ $item->name }}</option>
			@endforeach
		</select>
	</div>
	<div class="form-group">
		<label for="subthematic_id">Sous-thématique</label>
		<select name="subthematic_id" id="subthematic_id" class="form-control select2-allow-clear">
			<option></option>
			@if(!empty($callForProjects->subthematic_id))
				<option value="{{ $callForProjects->subthematic_id }}" selected>{{ $callForProjects->subthematic->name }}</option>
			@endif
		</select>
	</div>
	<div class="form-group">
		<label for="name">Intitulé*</label>
		<input type="text" class="form-control" name="name" id="name" value="{{ old('name', $callForProjects->name) }}">
	</div>
	<div class="form-group">
		<label for="closing_date">Date de clotûre</label>
		<div class="input-group date">
			<input type="text" class="form-control" name="closing_date" id="closing_date" value="{{ old('closing_date', $callForProjects->closing_date) }}">
			<span class="input-group-addon">
				<span class="glyphicon glyphicon-time"></span>
			</span>
		</div>
	</div>
	<div class="form-group">
		<label for="project_holder_id">Porteur du dispositif</label>
		<div class="input-group">
			<select name="project_holder_id" id="project_holder_id" class="form-control select2-allow-clear">
				@if(!empty($project_holder_id))
					@php($project_holder = \App\ProjectHolder::where('id', $project_holder_id)->first())
					@if(!empty($project_holder->id))
						<option value="{{ $project_holder->id }}" selected>{{ $project_holder->name }}</option>
					@endif
				@endif
			</select>
			<span class="input-group-btn">
				<button class="btn btn-default" type="button" data-toggle="modal" data-target="#modalNewProjectHolder"><i class="fa fa-plus" aria-hidden="true"></i></button>
			</span>
		</div>
	</div>
	<div class="form-group">
		<label for="perimeter_id">Périmètre</label>
		<div class="input-group">
			<select name="perimeter_id" id="perimeter_id" class="form-control select2-allow-clear">
				@if(!empty($perimeter_id))
					@php($perimeter = \App\Perimeter::where('id', $perimeter_id)->first())
					@if(!empty($perimeter->id))
						<option value="{{ $perimeter->id }}" selected>{{ $perimeter->name }}</option>
					@endif
				@endif
			</select>
			<span class="input-group-btn">
				<button class="btn btn-default" type="button" data-toggle="modal" data-target="#modalNewPerimeter"><i class="fa fa-plus" aria-hidden="true"></i></button>
			</span>
		</div>
	</div>
	<div class="form-group">
		<label for="objectives">Objectifs</label>
		<textarea class="form-control" rows="3" name="objectives" id="objectives">{{ old('objectives', $callForProjects->objectives) }}</textarea>
	</div>
	<div class="form-group">
		<label for="beneficiary_id">Bénéficiaire</label>
		<div class="input-group">
			<select name="beneficiary_id" id="beneficiary_id" class="form-control select2-allow-clear">
				@if(!empty($beneficiary_id))
					@php($beneficiary = \App\Beneficiary::where('id', $beneficiary_id)->first())
					@if(!empty($beneficiary->id))
						<option value="{{ $beneficiary->id }}" selected>{{ $beneficiary->name }}</option>
					@endif
				@endif
			</select>
			<span class="input-group-btn">
				<button class="btn btn-default" type="button" data-toggle="modal" data-target="#modalNewBeneficiary"><i class="fa fa-plus" aria-hidden="true"></i></button>
			</span>
		</div>
	</div>
	<div class="form-group">
		<label for="beneficiary_comments">Bénéficiaire - Observations</label>
		<textarea class="form-control" rows="3" name="beneficiary_comments" id="beneficiary_comments">{{ old('beneficiary_comments', $callForProjects->beneficiary_comments) }}</textarea>
	</div>
	<div class="form-group">
		<label>Dotation</label>
		<div class="checkboxes">
			<label class="checkbox-inline">
				<input type="checkbox" name="allocation_global" id="allocation_global" value="1" {{ empty($allocation_global) ? '' : 'checked="checked"' }}> Dotation globale
			</label>
			<label class="checkbox-inline">
				<input type="checkbox" name="allocation_per_project" id="allocation_per_project" value="1" {{ empty($allocation_per_project) ? '' : 'checked="checked"' }}> Dotation par projet
			</label>
		</div>
	</div>
	<div class="form-group">
		<label for="allocation_amount">Dotation - Montant</label>
		<input type="text" class="form-control" name="allocation_amount" id="allocation_amount" value="{{ old('allocation_amount', $callForProjects->allocation_amount) }}">
	</div>
	<div class="form-group">
		<label for="allocation_comments">Dotation - Commentaires</label>
		<textarea class="form-control" rows="3" name="allocation_comments" id="allocation_comments">{{ old('allocation_comments', $callForProjects->allocation_comments) }}</textarea>
	</div>
	<div class="form-group">
		<label for="technical_relay">Relais technique DREAL / DDTMs</label>
		<textarea class="form-control" rows="3" name="technical_relay" id="technical_relay">{{ old('technical_relay', $callForProjects->technical_relay) }}</textarea>
	</div>
	<div class="form-group">
		<label for="project_holder_contact">Contact(s) porteur de projet</label>
		<textarea class="form-control" rows="3" name="project_holder_contact" id="project_holder_contact">{{ old('project_holder_contact', $callForProjects->project_holder_contact) }}</textarea>
	</div>
	<div class="form-group">
		<label for="website_url">Adresse internet</label>
		<textarea class="form-control" rows="3" name="website_url" id="website_url">{{ old('website_url', $callForProjects->website_url) }}</textarea>
	</div>

	<button type="submit" class="btn btn-primary">Enregistrer</button>
</form>

@push('inline-script')
	<script>
		var $_subthematics_data = {!! $subthematics->toJson() !!};

		function initSubthematicData(start) {
			var thematic_id = $('#thematic_id').val();

			if(thematic_id == '') {
				return false;
			}

			var custom_data = [];
			if($_subthematics_data[thematic_id] !== undefined) {
				custom_data = $.map($_subthematics_data[thematic_id], function (obj) {
					var selected = false;
					if(start == true) {
						var value_selected = '{{ $subthematic_id }}';
						if(value_selected == obj.id) {
							selected = true;
						}
					}
					return {
						id: obj.id,
						text: obj.name,
						selected: selected
					}
				});
			}

			$('#subthematic_id').empty().append($('<option>')).select2({ data: custom_data, allowClear: true });
		}

		(function($) {
			"use strict";

			initSubthematicData(true);

			$('#closing_date').datetimepicker({
				format: 'YYYY-MM-DD',
				locale: 'fr',
				showClear: true
			});

			$('#thematic_id').on('change', function() {
				initSubthematicData();
			});

			$('#project_holder_id').select2({
				ajax: window.utils.select2__ajaxOptions('{{ route('bko.porteur-dispositif.select2') }}'),
				allowClear: true
			});

			$('#perimeter_id').select2({
				ajax: window.utils.select2__ajaxOptions('{{ route('bko.perimetre.select2') }}'),
				allowClear: true
			});

			$('#beneficiary_id').select2({
				ajax: window.utils.select2__ajaxOptions('{{ route('bko.beneficiaire.select2') }}'),
				allowClear: true
			});

			$('#save__modalNewProjectHolder').on('click', function() {
				window.utils.saveNewItem('modalNewProjectHolder', '{{ action('Bko\ProjectHolderController@store') }}', 'project_holder_id');
			});

			$('#save__modalNewPerimeter').on('click', function() {
				window.utils.saveNewItem('modalNewPerimeter', '{{ action('Bko\PerimeterController@store') }}', 'perimeter_id');
			});

			$('#save__modalNewBeneficiary').on('click', function() {
				window.utils.saveNewItem('modalNewBeneficiary', '{{ action('Bko\BeneficiaryController@store') }}', 'beneficiary_id');
			});

			$('#modalNewProjectHolder, #modalNewPerimeter, #modalNewBeneficiary').on('hidden.bs.modal', function (e) {
				var _this = $(this);
				_this.find('input[type="text"], textarea').val('');
				_this.find('input[type="radio"], input[type="checkbox"]').prop('checked', false);
			});
		})(jQuery);
	</script>
@endpush

@section('after-content')
	@component('bko.components.modals._default')
		@slot('id', 'modalNewProjectHolder')
		@slot('title', "Ajout d'un porteur du dispositif")
		@slot('slot')
			@include('bko.components.forms._default', [
				'model' => new \App\ProjectHolder(),
				'options' => [ 'method' => 'POST', 'url' => '#' ],
				'modal' => 'modalNewProjectHolder',
			])
		@endslot
		@slot('footer')
			<button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
			<button type="button" class="btn btn-primary" id="save__modalNewProjectHolder">Ajouter</button>
		@endslot
	@endcomponent

	@component('bko.components.modals._default')
		@slot('id', 'modalNewPerimeter')
		@slot('title', "Ajout d'un périmètre")
		@slot('slot')
			@include('bko.components.forms._default', [
				'model' => new \App\Perimeter(),
				'options' => [ 'method' => 'POST', 'url' => '#' ],
				'modal' => 'modalNewPerimeter',
			])
		@endslot
		@slot('footer')
			<button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
			<button type="button" class="btn btn-primary" id="save__modalNewPerimeter">Ajouter</button>
		@endslot
	@endcomponent

	@component('bko.components.modals._default')
		@slot('id', 'modalNewBeneficiary')
		@slot('title', "Ajout d'un bénéficiaire")
		@slot('slot')
			@include('bko.beneficiary._form', [
				'model' => new \App\Beneficiary(),
				'options' => [ 'method' => 'POST', 'url' => '#' ],
				'modal' => 'modalNewBeneficiary',
			])
		@endslot
		@slot('footer')
			<button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
			<button type="button" class="btn btn-primary" id="save__modalNewBeneficiary">Ajouter</button>
		@endslot
	@endcomponent
@endsection