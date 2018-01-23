@extends('layouts.bko')
@section('heading', "Dispositif financier : ".$callForProjects->name)
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
			<label class="col-lg-3 control-label">Date de clotûre</label>
			<div class="col-lg-9">
				<p class="form-control-static">{{ empty($callForProjects->closing_date) ? '' : $callForProjects->closing_date->format('d/m/Y') }}</p>
			</div>
		</div>
		<div class="form-group">
			<label class="col-lg-3 control-label">Porteur du dispositif</label>
			<div class="col-lg-9">
				<p class="form-control-static">{{ empty($callForProjects->project_holder_id) ? '' : $callForProjects->projectHolder->name }}</p>
			</div>
		</div>
		<div class="form-group">
			<label class="col-lg-3 control-label">Périmètre</label>
			<div class="col-lg-9">
				<p class="form-control-static">{{ empty($callForProjects->perimeter_id) ? '' : $callForProjects->perimeter->name }}</p>
			</div>
		</div>
		<div class="form-group">
			<label class="col-lg-3 control-label">Objectifs</label>
			<div class="col-lg-9">
				<p class="form-control-static">{{ $callForProjects->objectives }}</p>
			</div>
		</div>
		<div class="form-group">
			<label class="col-lg-3 control-label">Bénéficiaire</label>
			<div class="col-lg-9">
				<p class="form-control-static">{{ empty($callForProjects->beneficiary_id) ? '' : $callForProjects->beneficiary->name }}</p>
			</div>
		</div>
		<div class="form-group">
			<label class="col-lg-3 control-label">Bénéficiaire - Observations</label>
			<div class="col-lg-9">
				<p class="form-control-static">{!! nl2br($callForProjects->beneficiary_comments) !!}</p>
			</div>
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
				<p class="form-control-static">{{ $callForProjects->website_url }}</p>
			</div>
		</div>
	</div>
@endsection