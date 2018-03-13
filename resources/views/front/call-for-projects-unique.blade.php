@extends('layouts.app')

@section('meta_title', "Fiche complète | Dispositifs")

@section('breadcrumb')
    <li>
        <a href="{{ route('front.dispositifs') }}">Dispositifs</a>
        <span class="chevron">></span>
    </li>
    <li>
        <span>Fiche complète</span>
    </li>
@endsection

@section('content')
    <div class="page-content page-dispositif-unique">
        <h2>{{ $callForProjects->name }}</h2>

        <div class="content">
            <div class="first">
                @if(!empty($callForProjects->objectives))
                    <div class="page-item">
                        <div class="page-header">
                            <h3>Objectifs</h3>
                        </div>
                        <div class="item-content">{!! nl2br($callForProjects->objectives) !!}</div>
                    </div>
                @endif
                @if(!$callForProjects->beneficiaries->isEmpty())
                    <div class="page-item">
                        <div class="page-header">
                            <h3>Bénéficiaires</h3>
                        </div>
                        <div class="item-content">
                            <ul>
                                @foreach($callForProjects->beneficiaries->sortBy('type') as $beneficiary)
                                    <li>{{ $beneficiary->name_complete }}</li>
                                @endforeach
                            </ul>
                            <div class="description">{!! nl2br($callForProjects->beneficiary_comments) !!}</div>
                        </div>
                    </div>
                @endif
                @if(!$callForProjects->perimeters->isEmpty())
                    <div class="page-item">
                        <div class="page-header">
                            <h3>Périmètres</h3>
                        </div>
                        <div class="item-content">
                            <ul>
                                @foreach($callForProjects->perimeters->sortBy('name') as $perimeter)
                                    <li>{{ $perimeter->name }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
                @if(!$callForProjects->projectHolders->isEmpty())
                    <div class="page-item">
                        <div class="page-header">
                            <h3>Porteurs du dispositifs</h3>
                        </div>
                        <div class="item-content">
                            <ul>
                                @foreach($callForProjects->projectHolders->sortBy('name') as $projectHolder)
                                    <li>{{ $projectHolder->name }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
                @if(!empty($callForProjects->allocation_global) || !empty($callForProjects->allocation_per_project))
                    <div class="page-item">
                        <div class="page-header">
                            <h3>Dotation</h3>
                        </div>
                        <div class="item-content">
                            <ul class="allocation-list">
                                @if(!empty($callForProjects->allocation_global))
                                    <li>Dotation globale</li>
                                @endif
                                @if(!empty($callForProjects->allocation_per_project))
                                    <li>Dotation par projet</li>
                                @endif
                            </ul>
                            @if(!empty($callForProjects->allocation_amount))
                                <div class="description">
                                    <div class="strong">Montant :</div>
                                    <div>{{ $callForProjects->allocation_amount }}</div>
                                </div>
                            @endif
                            @if(!empty($callForProjects->allocation_comments))
                                <div class="description">
                                    <div class="strong">Observations :</div>
                                    <div>{!! nl2br($callForProjects->allocation_comments) !!}</div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
                @if(!empty($callForProjects->project_holder_contact))
                    <div class="page-item">
                        <div class="page-header">
                            <h3>Contact(s) porteurs du dispositif</h3>
                        </div>
                        <div class="item-content">{!! nl2br($callForProjects->project_holder_contact) !!}</div>
                    </div>
                @endif
                @if(!empty($callForProjects->technical_relay))
                    <div class="page-item">
                        <div class="page-header">
                            <h3>Relais technique DREAL / DDTMs</h3>
                        </div>
                        <div class="item-content">{!! nl2br($callForProjects->technical_relay) !!}</div>
                    </div>
                @endif
            </div>
            <div class="last">
                <div class="page-item">
                    <div class="page-header">
                        <h3>Informations générales</h3>
                    </div>
                    <div class="item-content">
                        <strong>Thématique</strong>
                        <p>{{ $callForProjects->thematic->name }}</p>
                    </div>
                    @if(!empty($callForProjects->subthematic->id))
                        <div class="item-content">
                            <strong>Sous-thématique</strong>
                            <p>{{ $callForProjects->subthematic->name }}</p>
                        </div>
                    @endif
                    <div class="item-content">
                        <strong>Date de clotûre</strong>
                        <p>{{ empty($callForProjects->closing_date) ? 'Non spécifié' : $callForProjects->closing_date->format('d/m/Y') }}</p>
                    </div>
                    @if(!empty($callForProjects->website_url))
                        <div class="item-content">
                            <strong>Site internet</strong>
                            <p>
                                <a href="{{ $callForProjects->website_url }}" target="_blank" title="{{ $callForProjects->website_url }} - Ouvrir dans une nouvelle fenêtre">
                                    Accéder au dispositif <i class="fa fa-external-link" aria-hidden="true"></i>
                                </a>
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection