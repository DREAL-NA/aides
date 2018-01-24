@extends('layouts.app')

@section('breadcrumb')
	<li>
		<span>Dispositifs de formation</span>
	</li>
@endsection

@section('content')
	<div class="page-content page-dispositifs">
		<h2>Dispositifs de formation</h2>
		@include('front.dispositifs.filters')

		<div class="content">
			<div class="content-dispositifs">
				<div class="page-header">
					<div class="page-title">
						<h3>Votre recherche</h3>
					</div>
					<div class="page-meta">
						<div class="result-count"><strong>10 Aides</strong> correspondent à votre recherche</div>
						<div class="helper-links">
							<?php // Icones Excel, PDF, CSV ?>
							Exporter les résultats
						</div>
					</div>
				</div>
				<section class="dispositif-items">
					<div class="dispositifs-items-header">
						<div class="beneficiary">Bénéficiaires</div>
						<div class="infos">Informations</div>
						<div class="closing-date">Date de clotûre</div>
					</div>
					@foreach($callsForProjects as $callForProjects)
						@php($url = route('front.dispositifs.unique', [ 'slug' => $callForProjects->slug ]))
						<article class="dispositif-item" data-id="{{ $callForProjects->id }}">
							<div class="beneficiary"><p>{!! $callForProjects->beneficiaries->unique()->sortBy('name_complete')->pluck('name_complete')->implode('</p><p>') !!}</p></div>
							<div class="infos">
								<div class="thematic">
									{{ $callForProjects->thematic->name }}
									@if(!empty($callForProjects->subthematic))
										/ {{ $callForProjects->subthematic->name }}
									@endif
								</div>
								<h4 class="title"><a href="{{ $url }}">{{ $callForProjects->name }}</a></h4>
								<div class="objectives">{{ \Illuminate\Support\Str::words($callForProjects->objectives, 50) }}</div>
								<div class="common-data-wrapper">
									@if(!$callForProjects->perimeters->isEmpty())
										<div class="common-data perimeters">
											<span class="label">Périmètres :</span>
											<div class="items">
												<p>{!! $callForProjects->perimeters->unique()->sortBy('name')->pluck('name')->implode('</p><p>') !!}</p>
											</div>
										</div>
									@endif
									@if(!$callForProjects->projectHolders->isEmpty())
										<div class="common-data perimeters">
											<span class="label">Porteurs du dispositif :</span>
											<div class="items">
												<p>{!! $callForProjects->projectHolders->unique()->sortBy('name')->pluck('name')->implode('</p><p>') !!}</p>
											</div>
										</div>
									@endif
									@if(!empty($callForProjects->website_url))
										<div class="common-data perimeters">
											<span class="label">Site internet :</span>
											<div class="items">
												<a class="external-link" href="{{ $callForProjects->website_url }}" target="_blank" title="Accéder au dispositif - Ouvrir dans une nouvelle fenêtre">
													Accéder au dispositif
													<i class="fa fa-external-link" aria-hidden="true"></i>
												</a>
											</div>
										</div>
									@endif
								</div>
								<a href="{{ $url }}" class="see-record">Voir la fiche complète</a>
							</div>
							<div class="closing-date">
								{{ empty($callForProjects->closing_date) ? '' : $callForProjects->closing_date->format('d/m/Y') }}
							</div>
						</article>
					@endforeach
				</section>
			</div>
		</div>
	</div>
@endsection