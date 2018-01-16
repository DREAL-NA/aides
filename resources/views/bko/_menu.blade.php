<div class="panel panel-default panel-menu">
	<div class="panel-heading">Menu</div>

	<div class="panel-body">
		<div class="menu-category">
			<h5 class="category-title">Appels à projets</h5>
			<ul class="menu">
				<li class="menu-item"><a href="{{ route('bko.call.index') }}">Liste des appels à projets ouverts</a></li>
				<li class="menu-item"><a href="{{ route('bko.call.indexClosed') }}">Liste des appels à projets clôturés</a></li>
				<li class="menu-item"><a href="{{ route('bko.call.create') }}">Ajouter un appel à projet</a></li>
				@yield('menu-item-call')
			</ul>
		</div>
		<div class="menu-category">
			<h5 class="category-title">Thématiques</h5>
			<ul class="menu">
				<li class="menu-item"><a href="{{ route('bko.thematic.index') }}">Liste des thématiques</a></li>
				<li class="menu-item"><a href="{{ route('bko.thematic.create') }}">Ajouter une thématique</a></li>
				@yield('menu-item-thematic')
			</ul>
		</div>
		<div class="menu-category">
			<h5 class="category-title">Sous-thématiques</h5>
			<ul class="menu">
				<li class="menu-item"><a href="{{ route('bko.subthematic.index') }}">Liste des sous-thématiques</a></li>
				<li class="menu-item"><a href="{{ route('bko.subthematic.create') }}">Ajouter une sous-thématique</a></li>
				@yield('menu-item-subthematic')
			</ul>
		</div>
	</div>
</div>