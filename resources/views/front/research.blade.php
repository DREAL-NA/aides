<section class="quick-search">

    <form action="{{ route('front.dispositifs', ['closed' => request('closed')]) }}"  class="form-dispositifs form-filters"  method="get">
        {{-- Barre de recherche --}}
        <p class="title__form">Quels sont les mot-clés de votre projet ?</p>

        <div class="search-container__form">

            <input type="text" id="query" name="query" value="{{ request()->get('query') ?: '' }}" placeholder="Entrez un ou plusieurs mot-clés">

            <button type="submit" id="rechercher"> <b>Rechercher</b>
                <span>{!! file_get_contents(public_path().'/svg/search.svg') !!}</span>
            </button>
        </div>


        {{-- filtres--}}
        <div>
            <a id="dispositifs-filters-button" href="#">
                <span>et/ou filtrez selon vos critères</span>
                <i class="fa fa-plus"></i>
                <i class="fa fa-minus"></i>
            </a>

            <div id="dispositifs-filters-container">

                <div class="filters-dispositifs">

                    <div class="filter-items">

                        <div class="row-filters">

                            <div class="filter-item">
                                <div class="titre-filtre">Vous êtes ?</div>
                                <select id="benef" name="{{ \App\Beneficiary::URI_NAME }}[]" class="filters-select" multiple >
                                    <option disabled>Association, entreprise, citoyen...</option>
                                    @foreach(\App\Beneficiary::types() as $key => $type){{--va chercher bénéficiaires--}}
                                    @php($selected = (!empty(request()->get(\App\Beneficiary::URI_NAME)) && in_array($key, request()->get(\App\Beneficiary::URI_NAME))) ?: false)
                                    <option value="{{ $key }}" {{ $selected ? 'selected="selected"' : '' }}>
                                    {{ $type . ($key === \App\Beneficiary::TYPE_OTHER ? '*' : '') }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="filter-item">
                                <div class="titre-filtre">Thématiques :</div>
                                <select name="{{ \App\Thematic::URI_NAME_THEMATIC }}[]" id="filter-thematic" class="filters-select" multiple>
                                    <option disabled>Thématiques des aides</option>
                                    @foreach($primary_thematics as $thematic)
                                    @php($selected = (!empty(request()->get(\App\Thematic::URI_NAME_THEMATIC)) && in_array($thematic->id, request()->get(\App\Thematic::URI_NAME_THEMATIC))) ?: false)
                                    <option value="{{ $thematic->id }}" {{ $selected ? 'selected="selected"' : '' }}>{{ $thematic->name }}</option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="filter-item">
                                <div class="titre-filtre">Votre localisation : <span id="perimeters"></span></div>
                                <select name="{{ \App\Perimeter::URI_NAME }}[]" id="perimeter-select" multiple></select>
                                <input type="search" id="perimeter" list="autocomplete_perimeters" placeholder="Gironde, Nouvelle-Aquitaine, ..." class="filters-select">
                                <ul id="autocomplete_perimeters" class="autocomplete">
                                    <!-- Options -->
                                </ul>
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



                        </div> {{-- fin class row-filters--}}


                        <div class="form-action">
                          <button type="submit" class="submit-filters">Valider et rechercher</button>
                            <button type="button" class="reset-filters">Réinitialiser les filtres</button>

                        </div>

                    </div> {{-- fin class filter-items --}}


                </div> {{--fin class filters-dispositifs--}}

            </div>{{--fin id dispositifs-filters-container--}}

        </div> {{-- fin filtres --}}

    </form>
</section>
