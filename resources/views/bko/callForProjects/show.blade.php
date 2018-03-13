@extends('layouts.bko')
@section('heading', "Dispositif : ".$callForProjects->name)
@section('menu-item-call')
    <li class="menu-item active"><a href="{{ route('bko.call.show', $callForProjects) }}">Voir la fiche {{ $callForProjects->name }}</a></li>
    <li class="menu-item"><a href="{{ route('bko.call.edit', $callForProjects) }}">Éditer {{ $callForProjects->name }}</a></li>
@endsection

@section('content')
    <div class="form-horizontal">
        <div class="form-group">
            <label class="col-lg-3 control-label">Thématique</label>
            <div class="col-lg-9">
                <p class="form-control-static">{{ $callForProjects->thematic->name }}</p>
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-3 control-label">Sous-thématique</label>
            <div class="col-lg-9">
                <p class="form-control-static">{{ empty($callForProjects->subthematic_id) ? '' : $callForProjects->subthematic->name }}</p>
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-3 control-label">Intitulé</label>
            <div class="col-lg-9">
                <p class="form-control-static">{{ $callForProjects->name }}</p>
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-3 control-label">Date de clôture</label>
            <div class="col-lg-9">
                <p class="form-control-static">{{ empty($callForProjects->closing_date) ? '' : $callForProjects->closing_date->format('d/m/Y') }}</p>
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-3 control-label">Porteurs du dispositif</label>
            <div class="col-lg-9">
                <p class="form-control-static">{{ $callForProjects->projectHolders->pluck('name')->implode(', ') }}</p>
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-3 control-label">Périmètres</label>
            <div class="col-lg-9">
                <p class="form-control-static">{{ $callForProjects->perimeters->pluck('name')->implode(', ') }}</p>
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-3 control-label">Objectifs</label>
            <div class="col-lg-9">
                <p class="form-control-static">{{ $callForProjects->objectives }}</p>
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-3 control-label">Bénéficiaires</label>
            <div class="col-lg-9">
                @if(!empty($callForProjects->beneficiaries))
                    @foreach($callForProjects->beneficiaries as $beneficiary)
                        <div class="beneficiary-item">
                            <p class="form-control-static"><b>Type :</b> {{ $beneficiary->type_label }}</p>
                            <p class="form-control-static"><b>Nom :</b> {{ $beneficiary->name }}</p>
                            <p class="form-control-static"><b>Description :</b><br>{!! nl2br($beneficiary->description) !!}</p>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-3 control-label">Bénéficiaires - Observations</label>
            <p class="form-control-static">{!! nl2br($callForProjects->beneficiary_comments) !!}</p>
        </div>
        <div class="form-group">
            <label class="col-lg-3 control-label">Dotation</label>
            <div class="col-lg-9">
                @php
                    $allocations = [];
                    if(!empty($callForProjects->allocation_global)) {
                        $allocations[] = 'Dotation globale';
                    }
                    if(!empty($callForProjects->allocation_per_project)) {
                        $allocations[] = 'Dotation par projet';
                    }
                @endphp
                <p class="form-control-static">{{ implode(' - ', $allocations) }}</p>
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-3 control-label">Dotation - Montant</label>
            <div class="col-lg-9">
                <p class="form-control-static">{{ $callForProjects->allocation_amount }}</p>
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-3 control-label">Dotation - Commentaires</label>
            <div class="col-lg-9">
                <p class="form-control-static">{!! nl2br($callForProjects->allocation_comments) !!}</p>
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-3 control-label">Relais technique DREAL / DDTMs</label>
            <div class="col-lg-9">
                <p class="form-control-static">{!! nl2br($callForProjects->technical_relay) !!}</p>
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-3 control-label">Contact(s) porteur de projet</label>
            <div class="col-lg-9">
                <p class="form-control-static">{!! nl2br($callForProjects->project_holder_contact) !!}</p>
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-3 control-label">Adresse internet</label>
            <div class="col-lg-9">
                <p class="form-control-static"><a href="{{ $callForProjects->website_url }}" target="_blank">{{ $callForProjects->website_url }}</a></p>
            </div>
        </div>
    </div>
@endsection