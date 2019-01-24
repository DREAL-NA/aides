<form action="{{ $options['url'] }}" method="post" enctype="multipart/form-data">
    {{ method_field($options['method']) }}
    {{ csrf_field() }}

    @php
        $thematic_id = old('thematic_id', $callForProjects->thematic_id);
        $subthematic_id = old('subthematic_id', $callForProjects->subthematic_id);
        if(!empty(old('project_holders'))) {
            $callForProjects->projectHolders = \App\ProjectHolder::whereIn('id', old('project_holders'))->get();
        }
        if(!empty(old('perimeters'))) {
            $callForProjects->perimeters = \App\Perimeter::whereIn('id', old('perimeters'))->get();
        }
        if(!empty(old('beneficiaries'))) {
            $callForProjects->beneficiaries = \App\Beneficiary::whereIn('id', old('beneficiaries'))->get();
        }
        $allocation_global = old('allocation_global', $callForProjects->allocation_global);
        $allocation_per_project = old('allocation_per_project', $callForProjects->allocation_per_project);
        $is_news = old('is_news', $callForProjects->is_news);
    @endphp

    @if(!empty($callForProjects->id))
        <div class="form-group">
            <label>Dernière édition par</label>
            <p class="form-control-static">
                <a href="mailto:{{ $callForProjects->editor->email }}">{{ $callForProjects->editor->name }}</a>
                le {{ $callForProjects->updated_at->format('d/m/Y') }}
            </p>
        </div>
    @endif

    <div class="form-group">
        <label>Cette aide apparaît dans la liste des actualités</label>
        <div class="checkboxes">
            <label class="radio-inline">
                <input type="radio" name="is_news" id="is_news" value="1" {{ empty($is_news) ? '' : 'checked="checked"' }}> Oui
            </label>
            <label class="radio-inline">
                <input type="radio" name="is_news" id="is_news" value="0" {{ empty($is_news) ? 'checked="checked"' : '' }}> Non
            </label>
        </div>
    </div>

    <div class="form-group">
        <label for="thematic_id">Thématique*</label>
        <div class="input-group">
            <select name="thematic_id" id="thematic_id" class="form-control select2-input">
                <option></option>
                @if(!is_null($callForProjects->thematic))
                    <option value="{{ $callForProjects->thematic->id }}" selected>{{ $callForProjects->thematic->name }}</option>
                @endif
            </select>
            <span class="input-group-btn">
				<button class="btn btn-default" type="button" data-toggle="modal" data-target="#modalNewThematic"><i class="fa fa-plus" aria-hidden="true"></i></button>
			</span>
        </div>
    </div>
    <div class="form-group">
        <label for="subthematic_id">Sous-thématique</label>
        <div class="input-group">
            <select name="subthematic_id" id="subthematic_id" class="form-control select2-input select2-allow-clear">
                <option></option>
                @if(!is_null($callForProjects->subthematic))
                    <option value="{{ $callForProjects->subthematic->id }}" selected>{{ $callForProjects->subthematic->name }}</option>
                @endif
            </select>
            <span class="input-group-btn">
				<button class="btn btn-default" type="button" data-toggle="modal" data-target="#modalNewSubthematic"><i class="fa fa-plus" aria-hidden="true"></i></button>
			</span>
        </div>
    </div>
    <div class="form-group">
        <label for="name">Intitulé*</label>
        <input type="text" class="form-control" name="name" id="name" value="{{ old('name', $callForProjects->name) }}">
    </div>
    <div class="form-group">
        <label for="closing_date">Date de clôture</label>
        <div class="input-group date">
            <input type="text" class="form-control" name="closing_date" id="closing_date" value="{{ old('closing_date', $callForProjects->closing_date) }}">
            <span class="input-group-addon">
				<span class="glyphicon glyphicon-time"></span>
			</span>
        </div>
    </div>
    <div class="form-group">
        <label for="project_holder_id">Financeur des aides</label>
        <div class="input-group">
            <select name="project_holders[]" id="project_holder_id" class="form-control select2-allow-clear" multiple>
                @if(!$callForProjects->projectHolders->isEmpty())
                    @foreach($callForProjects->projectHolders as $project_holder)
                        <option value="{{ $project_holder->id }}" selected>{{ $project_holder->name }}</option>
                    @endforeach
                @endif
            </select>
            <span class="input-group-btn">
				<button class="btn btn-default" type="button" data-toggle="modal" data-target="#modalNewProjectHolder"><i class="fa fa-plus" aria-hidden="true"></i></button>
			</span>
        </div>
    </div>
    <div class="form-group">
        <label for="perimeter_id">Votre localisation</label>
        <div class="input-group">
            <select name="perimeters[]" id="perimeter_id" class="form-control select2-allow-clear" multiple>
                @if(!$callForProjects->perimeters->isEmpty())
                    @foreach($callForProjects->perimeters as $perimeter)
                        <option value="{{ $perimeter->id }}" selected>{{ $perimeter->name }}</option>
                    @endforeach
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
        <label for="beneficiary_id">Vous êtes ?</label>
        <div class="input-group">
            <select name="beneficiaries[]" id="beneficiary_id" class="form-control select2-allow-clear" multiple>
                @if(!$callForProjects->beneficiaries->isEmpty())
                    @foreach($callForProjects->beneficiaries as $beneficiary)
                        <option value="{{ $beneficiary->id }}" selected>{{ $beneficiary->name_complete }}</option>
                    @endforeach
                @endif
            </select>
            <span class="input-group-btn">
				<button class="btn btn-default" type="button" data-toggle="modal" data-target="#modalNewBeneficiary"><i class="fa fa-plus" aria-hidden="true"></i></button>
			</span>
        </div>
    </div>
    <div class="form-group">
        <label for="beneficiary_comments">Vous êtes ? - Observations</label>
        <textarea class="form-control" rows="3" name="beneficiary_comments"
                  id="beneficiary_comments">{{ old('beneficiary_comments', $callForProjects->beneficiary_comments) }}</textarea>
    </div>
    <div class="form-group">
        <label>Dotation</label>
        <div class="checkboxes">
            <label class="checkbox-inline">
                <input type="checkbox" name="allocation_global" id="allocation_global" value="1" {{ empty($allocation_global) ? '' : 'checked="checked"' }}> Dotation globale
            </label>
            <label class="checkbox-inline">
                <input type="checkbox" name="allocation_per_project" id="allocation_per_project" value="1" {{ empty($allocation_per_project) ? '' : 'checked="checked"' }}> Dotation
                par projet
            </label>
        </div>
    </div>
    <div class="form-group">
        <label for="allocation_amount">Dotation - Montant</label>
        <input type="text" class="form-control" name="allocation_amount" id="allocation_amount" value="{{ old('allocation_amount', $callForProjects->allocation_amount) }}">
    </div>
    <div class="form-group">
        <label for="allocation_comments">Dotation - Commentaires</label>
        <textarea class="form-control" rows="3" name="allocation_comments"
                  id="allocation_comments">{{ old('allocation_comments', $callForProjects->allocation_comments) }}</textarea>
    </div>
    <div class="form-group">
        <label for="technical_relay">Relais technique DREAL / DDTMs</label>
        <textarea class="form-control" rows="3" name="technical_relay" id="technical_relay">{{ old('technical_relay', $callForProjects->technical_relay) }}</textarea>
    </div>
    <div class="form-group">
        <label for="project_holder_contact">Contact(s) porteur de projet</label>
        <textarea class="form-control" rows="3" name="project_holder_contact"
                  id="project_holder_contact">{{ old('project_holder_contact', $callForProjects->project_holder_contact) }}</textarea>
    </div>
    <div class="form-group">
        <label for="website_url">Adresse internet</label>
        <textarea class="form-control" rows="3" name="website_url" id="website_url">{{ old('website_url', $callForProjects->website_url) }}</textarea>
    </div>

    <div class="form-group">
        <label for="file">Fichier</label>
        @if(!empty($file = $callForProjects->getFile()))
            <div>
                <a href="{{ $file }}" target="_blank">{{ $file }}</a>
            </div>
            <br>
        @endif
        <input type="file" name="file" id="file" value="{{ old('file') }}">
    </div>

    <button type="submit" class="btn btn-primary">Enregistrer</button>
</form>

@push('inline-script')
    <script>
        function initSubthematicData(start) {
            var parent_id = $('#thematic_id').val();

            if (start !== true) {
                $('#subthematic_id').empty().append($('<option>'));
            }

            $('#subthematic_id').select2({
                ajax: window.utils.select2__ajaxOptions('{{ route('bko.subthematic.select2') }}?parent_id=' + parent_id),
                allowClear: true
            });
        }

        (function ($) {
            "use strict";

            initSubthematicData(true);

            $('#closing_date').datetimepicker({
                format: 'YYYY-MM-DD',
                locale: 'fr',
                showClear: true
            });

            $('#thematic_id').select2({
                ajax: window.utils.select2__ajaxOptions('{{ route('bko.thematic.select2') }}')
            }).on('change', function () {
                initSubthematicData();
            });

            $('#project_holder_id').select2({
                ajax: window.utils.select2__ajaxOptions('{{ route('bko.porteur-dispositif.select2') }}'),
                multiple: true
            });

            $('#perimeter_id').select2({
                ajax: window.utils.select2__ajaxOptions('{{ route('bko.perimetre.select2') }}'),
                multiple: true
            });

            $('#beneficiary_id').select2({
                ajax: window.utils.select2__ajaxOptions('{{ route('bko.beneficiaire.select2') }}'),
                multiple: true
            });

            $('#save__modalNewProjectHolder').on('click', function () {
                window.utils.saveNewItem('modalNewProjectHolder', '{{ action('Bko\ProjectHolderController@store') }}', 'project_holder_id');
            });

            $('#save__modalNewPerimeter').on('click', function () {
                window.utils.saveNewItem('modalNewPerimeter', '{{ action('Bko\PerimeterController@store') }}', 'perimeter_id');
            });

            $('#save__modalNewBeneficiary').on('click', function () {
                console.log('{{ action('Bko\BeneficiaryController@store') }}');
                window.utils.saveNewItem('modalNewBeneficiary', '{{ action('Bko\BeneficiaryController@store') }}', 'beneficiary_id');
            });

            $('#save__modalNewThematic').on('click', function () {
                window.utils.saveNewItem('modalNewThematic', '{{ action('Bko\ThematicController@store') }}', 'thematic_id');
            });

            $('#save__modalNewSubthematic').on('click', function () {
                window.utils.saveNewItem('modalNewSubthematic', '{{ action('Bko\SubthematicController@store') }}', 'subthematic_id');
            });

            $('#modalNewProjectHolder, #modalNewPerimeter, #modalNewBeneficiary, #modalNewThematic, #modalNewSubthematic').on('hidden.bs.modal', function (e) {
                var _this = $(this);
                _this.find('input[type="text"], textarea').val('');
                _this.find('input[type="radio"], input[type="checkbox"]').prop('checked', false);
                _this.find('.select2-input').val('').trigger('change');
            });

            $('#modalNewSubthematic').on('show.bs.modal', function (e) {
                var thematic_id = $('#thematic_id').val();

                if (thematic_id === undefined || thematic_id === '') {
                    return false;
                }

                var thematic_text = $('#thematic_id option[value="' + thematic_id + '"]').text();

                var option = new Option(thematic_text, thematic_id, true, true);
                $('#modalNewSubthematic #parent_id__modalNewSubthematic').html(option).trigger('change');
            });
        })(jQuery);
    </script>
@endpush

@section('after-content')
    @component('bko.components.modals._default')
        @slot('id', 'modalNewProjectHolder')
        @slot('title', "Ajout d'un financeurs des aides")
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
        @slot('title', "Ajout d'une localisation")
        @slot('slot')
            @include('bko.perimeter._form', [
                'model' => new \App\Perimeter(),
                'options' => [ 'method' => 'POST', 'url' => '#' ],
                'modal' => 'modalNewPerimeter',
                'parents' => $perimeters
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

    @component('bko.components.modals._default')
        @slot('id', 'modalNewThematic')
        @slot('title', "Ajout d'une thématique")
        @slot('slot')
            @include('bko.components.forms._default', [
                'model' => new \App\Thematic(),
                'options' => [ 'method' => 'POST', 'url' => '#' ],
                'modal' => 'modalNewThematic',
            ])
        @endslot
        @slot('footer')
            <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
            <button type="button" class="btn btn-primary" id="save__modalNewThematic">Ajouter</button>
        @endslot
    @endcomponent

    @component('bko.components.modals._default')
        @slot('id', 'modalNewSubthematic')
        @slot('title', "Ajout d'une sous-thématique")
        @slot('slot')
            @include('bko.subthematic._form', [
                'thematic' => new \App\Thematic,
                'options' => [ 'method' => 'POST', 'url' => action('Bko\SubthematicController@store') ],
                'modal' => 'modalNewSubthematic',
            ])
        @endslot
        @slot('footer')
            <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
            <button type="button" class="btn btn-primary" id="save__modalNewSubthematic">Ajouter</button>
        @endslot
    @endcomponent
@endsection