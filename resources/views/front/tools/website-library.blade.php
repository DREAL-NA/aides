@extends('layouts.app')

@section('meta_title', "Sitothèque")

@section('breadcrumb')
	<li>
		<span>Outils</span>
		<span class="chevron">></span>
	</li>
	<li>
		<span>Sitothèque</span>
	</li>
@endsection

@section('content')
	<div class="page-content page-websites">
		<h2>Sitothèque</h2>
		<div class="content">
			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus felis orci, ultrices at blandit non, tincidunt eu enim. Sed convallis porta elit nec efficitur. Fusce nec turpis vel sapien imperdiet venenatis. Nam interdum sem dolor, et consequat nibh feugiat vitae. Donec mollis a sapien non rutrum. Morbi turpis magna, commodo nec ex vel, commodo mollis nisl. Proin urna est, viverra nec velit ac, suscipit feugiat ante. Morbi cursus commodo dolor ac dignissim. Proin volutpat aliquet ligula, vel vulputate magna feugiat non. Duis maximus urna turpis, quis hendrerit lectus pulvinar vel. Sed eu nunc vitae urna volutpat bibendum. Morbi eleifend cursus ex, blandit interdum ex ullamcorper ut. Sed dictum ex eget dolor tincidunt sollicitudin. Maecenas tristique laoreet diam sit amet dignissim.</p>

			<section class="website-items">
				<div class="website-items-header">
					<div class="first hidden-xs">Structure</div>
					<div class="middle infos">Informations</div>
					<div class="last website-url hidden-xs">Site internet</div>
				</div>
				@foreach($websites as $website)
					<article class="website-item">
						<div class="first hidden-xs structure">{{ $website->organizationType->name }}</div>
						<div class="middle infos">
							<h4 class="title">{{ $website->name }}</h4>
							<div class="visible-xs"><strong>{{ $website->organizationType->name }}</strong></div>
							<div class="description">{!! nl2br($website->description) !!}</div>
							@if(!empty($website->themes))
								@php($themes = collect(explode(PHP_EOL, $website->themes)))
								<div class="common-data themes">
									<span class="label">Thèmes :</span>
									<div class="items">
										<p>{!! $themes->sortBy('name')->implode('</p><p>') !!}</p>
									</div>
								</div>
							@endif
							@if(!$website->perimeters->isEmpty())
								<div class="common-data perimeters">
									<span class="label">Périmètres :</span>
									<div class="items">
										<p>{!! $website->perimeters->unique()->sortBy('name')->pluck('name')->implode('</p><p>') !!}</p>
									</div>
								</div>
							@endif
							<div class="website-url visible-xs">
								@foreach($website->url_array as $url)
									<a href="{{ $url }}" target="_blank" title="Aller sur le site - Ouvrir dans une nouvelle fenêtre">
										Aller sur le site
										<i class="fa fa-external-link" aria-hidden="true"></i>
									</a>
								@endforeach
							</div>
						</div>
						<div class="last website-url hidden-xs">
							@foreach($website->url_array as $url)
								<a href="{{ $url }}" target="_blank" title="Aller sur le site - Ouvrir dans une nouvelle fenêtre">
									Aller sur le site
									<i class="fa fa-external-link" aria-hidden="true"></i>
								</a>
							@endforeach
						</div>
					</article>
				@endforeach
			</section>
		</div>
	</div>
@endsection