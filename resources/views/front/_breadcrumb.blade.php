<nav role="navigation" class="breadcrumb-nav">
	<ul>
		<li>
			<a href="{{ route('front.home') }}">Accueil</a>
			<span class="chevron">></span>
		</li>
		@yield('breadcrumb')
	</ul>
</nav>