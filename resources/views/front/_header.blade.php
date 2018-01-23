<header>
	<a href="{{ route('front.home') }}" class="link-marianne">
		@include('svg.marianne')
	</a>
	<div class="container">
		<a href="{{ route('front.home') }}" class="link-title">
			<h1>{{ ucfirst(config('app.domain')) }}</h1>
			<p class="description">La base de données de référence sur les aides aux territoires ouverte à tous</p>
		</a>
	</div>
</header>