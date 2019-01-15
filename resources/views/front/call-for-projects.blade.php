@extends('layouts.app')

@section('meta_title', "Dispositifs")

@section('breadcrumb')
    <li>
        <span>Dispositifs</span>
    </li>
@endsection

@section('content')
    <div class="page-content page-dispositifs">
        <h2>
            <span>Dispositifs{{ $callsAreClosedOnes ? ' clôturés' : '' }}</span>
            <a href="{{ route('front.dispositifs', ['closed' => $callsAreClosedOnes ? false : 'clotures']) }}">Voir les
                dispositifs {{ $callsAreClosedOnes ? 'ouverts' : 'clôturés' }}</a>
        </h2>
        @include('front.dispositifs.filters')

        <div class="content">
            <div class="content-dispositifs">
                <div class="page-header no-bottom">
                    <div class="page-title">
                        <h2>Votre recherche</h2>
                    </div>
                    <div class="page-meta">
                        <div class="result-count">
                            <strong>{{ trans_choice('messages.dispositifs.count', $callsForProjects->total()) }}</strong>
                            correspondent à votre recherche
                        </div>
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
                <section class="dispositif-items">
                    <div class="dispositifs-items-header">
                        <div class="first beneficiary hidden-xs">Bénéficiaires</div>
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
                                    {{ $callForProjects->thematic->name }}
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
                                            <span class="label">Bénéficiaires :</span>
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
                                            <span class="label">Périmètres :</span>
                                            <div class="items">
                                                <p>{!! $callForProjects->perimeters->unique()->sortBy('name')->pluck('name')->implode('</p><p>') !!}</p>
                                            </div>
                                        </div>
                                    @endif
                                    @if(!$callForProjects->projectHolders->isEmpty())
                                        <div class="common-data projectHolders">
                                            <span class="label">Porteurs du dispositif :</span>
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
                                                   title="Accéder au dispositif - Ouvrir dans une nouvelle fenêtre">
                                                    Accéder au dispositif
                                                    <i class="fa fa-external-link" aria-hidden="true"></i>
                                                </a>
                                            </div>
                                        </div>
                                    @endif
                                    @if(!empty($file = $callForProjects->getFile()))
                                        <div class="common-data">
                                            <span class="label">Fichier associé :</span>
                                            <div class="items">
                                                <a class="external-link" href="{{ $file }}"
                                                   target="_blank"
                                                   title="Télécharger le fichier - Ouvrir dans une nouvelle fenêtre">
                                                    Télécharger le fichier
                                                    <i class="fa fa-external-link" aria-hidden="true"></i>
                                                </a>
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
                    @if($callsForProjects->isEmpty())
                        <p class="dispositifs-empty">Aucune aide ne correspond à votre recherche. Veuillez modifier vos
                            filtres.</p>
                    @endif
                </section>
                {{ $callsForProjects->appends($pagination_appends)->links() }}
            </div>
        </div>
    </div>
@endsection