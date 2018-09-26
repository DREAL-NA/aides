<div class="filters-dispositifs">
    <h4>Affiner votre recherche</h4>
    <form action="{{ route('front.dispositifs', ['closed' => request('closed')]) }}" class="form-dispositifs form-filters" method="get">
        <div class="filter-items">
            <div class="row-filters">
                <div class="filter-item">
                    <select name="{{ \App\Thematic::URI_NAME_THEMATIC }}[]" id="filter-thematic" class="filters-select" multiple>
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
                            <optgroup label="{{ $primary->name }}" data-id="{{ $primary->id }}">
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
                            @php($selected = (!empty($paramsPerimeters) && $paramsPerimeters->contains($perimeter->id)) ?: false)
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
            <div class="row-filters">
                <div class="filter-item">
                    <?php
                    $date = "";
                    if (!empty(request()->get('date')) && \App\Helpers\Date::isValid(request()->get('date'))) {
                        $date = \Carbon\Carbon::createFromFormat('d/m/Y', request()->get('date'))->format('d/m/Y');
                    }
                    ?>
                    <input type="text" class="form-control datepicker-here" name="date" id="filter_closing_date" placeholder="Date de clôture minimum" value="{{ $date }}">
                </div>
                <div class="filter-item filter-item-checkbox">
                    <label for="closing_date_null">
                        @php($checked = (request()->get('date_null') && request()->get('date_null') == 1) ?: false)
                        <span class="text">Afficher seulement les dispositifs sans date de clôture</span>
                        <div class="checkbox">
                            <input type="checkbox" name="date_null" id="closing_date_null" class="tgl tgl-light" {{ $checked ? 'checked' : '' }} value="1">
                            <label class="tgl-btn" for="closing_date_null"></label>
                        </div>
                    </label>
                </div>
            </div>
        </div>
        <div class="form-action">
            <button type="button" class="reset-filters">Réinitialiser les filtres</button>
            <button type="button" class="submit-filters">Rechercher</button>
        </div>
    </form>
</div>