<div class="filters-dispositifs">
    @if(isset($has_title) && $has_title === true)
        <h4>Affiner votre recherche</h4>
    @endif
    <form action="{{ route('front.dispositifs', ['closed' => request('closed')]) }}" class="form-dispositifs form-filters" method="get">
        <div class="filter-items">
            @if(request()->routeIs('front.dispositifs'))
                <div class="row-filters">
                    <div class="filter-item-search-input">
                        <input type="text" placeholder="Rechercher une aide" name="query" value="{{ request()->get('query') ?: '' }}">
                    </div>
                </div>
            @endif

            <div class="row-filters">
                <div class="filter-item">
                    <select name="{{ \App\Beneficiary::URI_NAME }}[]" class="filters-select" multiple>
                        <option disabled>Vous êtes ?</option>
                        @foreach(\App\Beneficiary::types() as $key => $type)
                            @php($selected = (!empty(request()->get(\App\Beneficiary::URI_NAME)) && in_array($key, request()->get(\App\Beneficiary::URI_NAME))) ?: false)
                            <option value="{{ $key }}" {{ $selected ? 'selected="selected"' : '' }}>{{ $type }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="filter-item">
                    <select name="{{ \App\Thematic::URI_NAME_THEMATIC }}[]" id="filter-thematic" class="filters-select" multiple>
                        <option disabled>Thématiques des aides</option>
                        @foreach($primary_thematics as $thematic)
                            @php($selected = (!empty(request()->get(\App\Thematic::URI_NAME_THEMATIC)) && in_array($thematic->id, request()->get(\App\Thematic::URI_NAME_THEMATIC))) ?: false)
                            <option value="{{ $thematic->id }}" {{ $selected ? 'selected="selected"' : '' }}>{{ $thematic->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="filter-item">
                    <select name="{{ \App\Perimeter::URI_NAME }}[]" class="filters-select" multiple>
                        <option disabled>Votre localisation</option>
                        @foreach($perimeters as $perimeter)
                            @php($selected = (!empty($paramsPerimeters) && $paramsPerimeters->contains($perimeter->id)) ?: false)
                            <option value="{{ $perimeter->id }}" {{ $selected ? 'selected="selected"' : '' }}>{{ $perimeter->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="filter-item">
                    <select name="{{ \App\ProjectHolder::URI_NAME }}[]" class="filters-select" multiple>
                        <option disabled>Financeurs des aides</option>
                        @foreach($project_holders as $project_holder)
                            @php($selected = (!empty(request()->get(\App\ProjectHolder::URI_NAME)) && in_array($project_holder->id, request()->get(\App\ProjectHolder::URI_NAME))) ?: false)
                            <option value="{{ $project_holder->id }}" {{ $selected ? 'selected="selected"' : '' }}>{{ $project_holder->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="form-action">
            <button type="button" class="reset-filters">Réinitialiser les filtres</button>
            <button type="submit" class="submit-filters">Rechercher</button>
        </div>

        <div class="helps">
            <p>Un autre acteur du territoire peut correspondre à : agence, centre, chambre, comité, communauté, coopérative, établissement, fédération, foyer, gestionnaire,
                institut, laboratoire, maître d’ouvrage, organisation, organisme, parc, personne morale, plateforme, pôle, porteur de projet, recherche, regroupement, société,
                structure, syndicat, ...</p>
        </div>
    </form>
</div>