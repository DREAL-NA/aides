<div class="filters-dispositifs">


        <div class="filter-items">
            {{--}}
           @if(request()->routeIs('front.dispositifs'))
                <div class="row-filters">
                    <div class="filter-item-search-input">
                        <input type="text" placeholder="Rechercher une aide" name="query" value="{{ request()->get('query') ?: '' }}">
                    </div>
                </div>
            @endif--}}


            <div class="row-filters">

                <div class="filter-item">
                    <div class="titre-filtre">Vous êtes ?</div>
                    <select id="benef" name="{{ \App\Beneficiary::URI_NAME }}[]" class="filters-select" multiple >
                        <option disabled>Association, entreprise, citoyen...</option>

                        @foreach(\App\Beneficiary::types() as $key => $type){{--va chercher bénéficiaires--}}
                            @php($selected = (!empty(request()->get(\App\Beneficiary::URI_NAME)) && in_array($key, request()->get(\App\Beneficiary::URI_NAME))) ?: false)
                            <option value="{{ $key }}" {{ $selected ? 'selected="selected"' : '' }}>
                                {{ $type . ($key === \App\Beneficiary::TYPE_OTHER ? '*' : '') }}

                                {{--}}{{$selected ? 'yes' : 'not'}}
                                {{$key}}
                                {{ \App\Beneficiary::URI_NAME }} --}}
                            </option>
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

    {{--
        @foreach(\App\Beneficiary::types() as $key => $type)
    @php($selected = (!empty(request()->get(\App\Beneficiary::URI_NAME)) && in_array($key, request()->get(\App\Beneficiary::URI_NAME))) ?: true)
    <span>{{$selected ? 'selected' : 'notsel.'}}</span>
    @if($selected){{ $type . ($key === \App\Beneficiary::TYPE_OTHER ? $type : '') }}@endif
    @endforeach--}}








            <div class="filter-item">
                <div class="titre-filtre">Votre localisation :</div>
                <select name="{{ \App\Perimeter::URI_NAME }}[]" class="filters-select" multiple>
            <option disabled>Gironde, Dorgogne...</option>
            @foreach($perimeters as $perimeter)
                @php($selected = (!empty($paramsPerimeters) && $paramsPerimeters->contains($perimeter->id)) ?: false)
                <option value="{{ $perimeter->id }}" {{ $selected ? 'selected="selected"' : '' }}>{{ $perimeter->name }}</option>
            @endforeach
            </select>
            </div>

            <div class="filter-item">
                <div class="titre-filtre">Financeurs :</div>

                <select name="{{ \App\ProjectHolder::URI_NAME }}[]" class="filters-select" multiple>
                    <option disabled>ADEME, région Nouvelle-Aquitaine...</option>
                    @foreach($project_holders as $project_holder)
                        @php($selected = (!empty(request()->get(\App\ProjectHolder::URI_NAME)) && in_array($project_holder->id, request()->get(\App\ProjectHolder::URI_NAME))) ?: false)
                        <option value="{{ $project_holder->id }}" {{ $selected ? 'selected="selected"' : '' }}>{{ $project_holder->name }}</option>
                    @endforeach
                </select>
            </div>

        </div>
    </div>

    {{--
    <div class="form-action">
        <button type="button" class="reset-filters">Réinitialiser les filtres</button>
        <button type="submit" class="submit-filters">Rechercher</button>
    </div> --}}

</div>