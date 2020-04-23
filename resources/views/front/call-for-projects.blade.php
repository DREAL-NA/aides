@extends('layouts.app')

@section('meta_title', "Aides")

@section('breadcrumb')
    <li>
        <span>Aides</span>
    </li>
@endsection

@section('content')
    <div class="page-content page-dispositifs">

@include('front.research')



        {{-- 1ère ligne de titre : rappel de la recherche, bouton pour passer aux aides cloturées / aides ouvertes --}}
        <h2>
            <span>
                {{-- S'il y a une requête écrite et des filtres  --}}
                @if(    ( !empty(request()->get('query'))) && (  ( !empty(request()->input('benef.0')))  || ( !empty(request()->input('thema.0'))) || ( !empty(request()->input('perim.0')))  || ( !empty(request()->input('proje.0')))  ) )

                    <strong>{{ trans_choice('messages.dispositifs.count', $callsForProjects->total()) }} {{ $callsAreClosedOnes ? 'clôturées' : 'en cours' }}</strong> pour : "{{ $callsAreClosedOnes ? '(aides clôturées) ' : '' }}{{ request()->get('query') }}" et pour vos filtres


                {{-- S'il y seulement des filtres  --}}
                @elseif (    ( empty(request()->get('query'))) && (  ( !empty(request()->input('benef.0')))  || ( !empty(request()->input('thema.0'))) || ( !empty(request()->input('perim.0')))  || ( !empty(request()->input('proje.0')))  ) )

                    <strong>{{ trans_choice('messages.dispositifs.count', $callsForProjects->total()) }}</strong> pour vos filtres

                {{-- S'il y seulement une requête écrite --}}
                @elseif (    ( !empty(request()->get('query'))) && (  ( empty(request()->input('benef.0')))  && ( empty(request()->input('thema.0'))) && ( empty(request()->input('perim.0')))  && ( empty(request()->input('proje.0')))  ) )

                    <strong>{{ trans_choice('messages.dispositifs.count', $callsForProjects->total()) }}{{ $callsAreClosedOnes ? 'clôturées' : 'en cours' }}</strong> pour : "{{ request()->get('query') }}"

                {{-- S'il n'y a rien --}}
                @else
                    {{ trans_choice('messages.dispositifs.count', $callsForProjects->total()) }} {{ $callsAreClosedOnes ? 'clôturées' : 'en cours' }}

                @endif

            </span>

            @php
                $route = route('front.dispositifs', ['closed' => $callsAreClosedOnes ? false : 'clotures']);
                if(!empty(request()->all())) {
                    $route .= '?'.http_build_query(request()->all());
                }
            @endphp

            <a href="{{ $route }}">Voir les aides {{ $callsAreClosedOnes ? 'ouvertes' : 'clôturées' }}</a>
        </h2>


        <div class="content-dispositifs">
            <div class="page-header no-bottom">
                <div class="page-meta">

                    <!--
                    <div class="result-count">
                        <strong>{{ trans_choice('messages.dispositifs.count', $callsForProjects->total()) }}</strong>
                        @if(!empty(request()->get('query')))
                        correspondent à votre recherche
                            @else recensées
                        @endif-->

                </div>


                {{-- Export --}}
                    @if(!$callsAreClosedOnes)
                        <div class="helper-links">
                            <?php // Icones Excel, PDF, CSV ?>
                            <span>Exporter les résultats :</span>
                            <a href="{{ route('export.csv', ['table' => 'dispositifs']) }}"
                               class="export-results export-results-ods"
                               title="Exporter les résultats - CSV"
                            >CSV <i class="fa fa-file-text-o" aria-hidden="true"></i></a>

                            <a href="{{ route('export.xlsx') }}"
                               class="export-results export-results-excel"
                               title="Exporter les résultats - Excel"
                            >Excel <i class="fa fa-file-excel-o" aria-hidden="true"></i></a>

                            <a href="{{ route('export.pdf') }}" class="export-results export-results-pdf"
                               title="Exporter les résultats - PDF"
                            >PDF <i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>

                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Résultats --}}
        <div class="content">
            <div class="content-dispositifs">
                <section class="dispositif-items">
                    <div class="dispositifs-items-header">
                        <div class="first beneficiary hidden-xs">Vous êtes ?</div>
                        <div class="middle infos">Informations</div>
                        <div class="last closing-date hidden-xs">Date de clôture</div>
                    </div>
                    @foreach($callsForProjects as $callForProjects)
                        @php($url = route('front.dispositifs.unique', [ 'slug' => $callForProjects->slug ]))
                        <article class="dispositif-item" data-id="{{ $callForProjects->id }}">
                            <div class="first beneficiary hidden-xs">
                                @foreach($callForProjects->beneficiaries->unique()->sortBy('name_complete') as $beneficiary)
                                    @php($selected = (!empty(request()->get(\App\Beneficiary::URI_NAME)) && in_array($beneficiary->type, request()->get(\App\Beneficiary::URI_NAME))) ?: false)
                                    <p class="{{ $selected ? 'mark' : '' }}">{{ $beneficiary->name_complete }}</p>
                                @endforeach
                            </div>
                            <div class="middle infos">
                                <div class="thematic">
                                    @if($callForProjects->thematic->name != "Autre")
                                        {{ $callForProjects->thematic->name }}
                                    @endif
                                    @if(!empty($callForProjects->subthematic))
                                        / {{ $callForProjects->subthematic->name }}
                                    @endif
                                </div>
                                <h4 class="title">
                                    <a href="{{ $url }}">{{ $callForProjects->name }}</a>
                                </h4>
                                <div class="objectives">{{ \Illuminate\Support\Str::words($callForProjects->objectives, 50) }}</div>
                                <div class="common-data-wrapper">
                                    @if(!empty($callForProjects->closing_date))
                                        <div class="common-data closing-date visible-xs">
                                            <span class="label">Date de clôture :</span>
                                            <div class="items">
                                                <p>{{ $callForProjects->closing_date->format('d/m/Y') }}</p>
                                            </div>
                                        </div>
                                    @endif
                                    @if(!$callForProjects->beneficiaries->isEmpty())
                                        <div class="common-data beneficiaries visible-xs">
                                            <span class="label">Vous êtes ? :</span>
                                            <div class="items">
                                                @foreach($callForProjects->beneficiaries->unique()->sortBy('name_complete') as $beneficiary)
                                                    @php($selected = (!empty(request()->get(\App\Beneficiary::URI_NAME)) && in_array($beneficiary->type, request()->get(\App\Beneficiary::URI_NAME))) ?: false)
                                                    <p class="{{ $selected ? 'mark' : '' }}">{{ $beneficiary->name_complete }}</p>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                    @if(!$callForProjects->perimeters->isEmpty())
                                        <div class="common-data perimeters">
                                            <span class="label">Localisations :</span>
                                            <div class="items">
                                                <p>{!! $callForProjects->perimeters->unique()->sortBy('name')->pluck('name')->implode('</p><p>') !!}</p>
                                            </div>
                                        </div>
                                    @endif
                                    @if(!$callForProjects->projectHolders->isEmpty())
                                        <div class="common-data projectHolders">
                                            <span class="label">Financeurs des aides :</span>
                                            <div class="items">
                                                <p>{!! $callForProjects->projectHolders->unique()->sortBy('name')->pluck('name')->implode('</p><p>') !!}</p>
                                            </div>
                                        </div>
                                    @endif
                                    @if(!empty($callForProjects->website_url))
                                        <div class="common-data">
                                            <span class="label">Site internet :</span>
                                            <div class="items">
                                                <a class="external-link" href="{{ $callForProjects->website_url }}"
                                                   target="_blank"
                                                   title="Accéder à l'aide - Ouvrir dans une nouvelle fenêtre">
                                                    Accéder à l'aide
                                                    <i class="fa fa-external-link" aria-hidden="true"></i>
                                                </a>
                                            </div>
                                        </div>
                                    @endif
                                    @if(!empty($files = $callForProjects->getFiles()) && !$files->isEmpty())
                                        <div class="common-data">
                                            <span class="label">Fichiers associés :</span>
                                            <div class="items">
                                                @foreach($files as $file)
                                                    <div>
                                                        <a class="external-link" href="{{ $file->getUrl() }}"
                                                           target="_blank"
                                                           title="Télécharger le fichier - Ouvrir dans une nouvelle fenêtre">
                                                            Télécharger le fichier
                                                            <i class="fa fa-external-link" aria-hidden="true"></i>
                                                        </a>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <a href="{{ $url }}" class="see-record">Voir la fiche complète</a>
                            </div>
                            <div class="last closing-date hidden-xs">
                                {{ empty($callForProjects->closing_date) ? '' : $callForProjects->closing_date->format('d/m/Y') }}
                            </div>
                        </article>
                    @endforeach

                    {{-- message si pas d'aide trouvées --}}
                    @if($callsForProjects->isEmpty())
                        <p class="dispositifs-empty">Désolé, nous n'avons pas trouvé d'aide correspondante à votre recherche.</p>
                        <p class="text-center">Essayez des mot-clés synonymes, modifiez les filtres, ou <strong><a class="{{ Route::is('front.home') ? 'current' : '' }}" href="{{ route('front.home') }}#newsletter">inscrivez-vous à notre newsletter</a></strong> pour être au courant des nouvelles aides ajoutées.<p/>
                    @endif

                </section>
                {{ $callsForProjects->appends($pagination_appends)->links() }}
            </div>
        </div>

    </div>
@endsection
<<<<<<< HEAD

@push('inline-script')
     <script>
         (function ($) {
             "use strict";

            // Autocomplete for perimeters
            let search = ''

             $('#perimeter').keyup( event => {
                const value = event.target.value

                if (value === '') {
                    $('.autocomplete').empty()
                }
                // if search has changed
                if (value !== search) {
                    search = value
                } else {
                    return
                }
                $.getJSON(`/api/autocomplete/perimeters?query=${value}`, perimeters => {
                    $('#autocomplete_perimeters').empty()
                    const options = perimeters.slice(0, 5).map( suggestion => {
                        const option = genererOption(suggestion)
                        return option
                    })
                    options.forEach( opt => document.getElementById('autocomplete_perimeters').appendChild(opt))
                })
             })

             const buildOptionsFromList = () => {
                $('#perimeter-select').empty()
                perimetersSelected.forEach( perimeter => {
                    $('#perimeter-select').append(`<option selected value="${perimeter.id}">${perimeter.nom}</option>`)
                })
             }

             const genererOption = suggestion => {
                 let option = document.createElement('li')
                 let text = document.createTextNode(`${suggestion.name} - ${suggestion.type}`)
                 option.dataset['id'] = suggestion.id
                 option.dataset['nom'] = suggestion.name
                 option.appendChild(text)
                 option.classList.add('selectable')
                 return option
             }

             const perimetersSelected = []

             const resetAutocomplete = () => {
                 $('.autocomplete').empty()
                 $('#perimeter').val('')
                 $('#perimeter').focus()
             }

             const addPerimeter = perimeter => {
                perimetersSelected.push(perimeter);
                // Generate span element
                const spanPerimeter = document.createElement('span')
                spanPerimeter.classList.add('perimeter-tag')
                spanPerimeter.appendChild(document.createTextNode(perimeter.nom))
                const closeButton = document.createElement('a')
                closeButton.classList.add('closable')
                closeButton.innerText = '❌'
                closeButton.dataset.id = perimeter.id
                spanPerimeter.appendChild(closeButton)

                $("#perimeters").append(spanPerimeter)
                $('#perimeter-select').empty()
                
                buildOptionsFromList()
             }

             const onSelectableClick = event => {
                 const perimeter = {
                     id: event.target.dataset.id,
                     nom: event.target.dataset.nom
                 }
                resetAutocomplete()
                addPerimeter(perimeter)
             }

             $(document).on('click', '.selectable', onSelectableClick)

             const onCloseButtonClick = event => {
                const perimeterID = $(event.target).data('id')
                $(event.target).parent().remove()
                perimetersSelected.splice(perimetersSelected.indexOf(perimeterID), 1)
                buildOptionsFromList()
             }

             $(document).on('click', '.closable', onCloseButtonClick)

         })(jQuery);
     </script>
 @endpush
=======
>>>>>>> Dispositifs : rectificatif affichage du nombre d'aide
