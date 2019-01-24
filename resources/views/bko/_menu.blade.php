<div class="panel panel-default panel-menu">
    <div class="panel-heading">Menu</div>

    <div class="panel-body">
        <div class="menu-category">
            <h5 class="category-title"><a href="{{ route('bko.home') }}">Tableau de bord</a></h5>
        </div>

        <div class="menu-category">
            <h5 class="category-title">Aides</h5>
            <ul class="menu">
                <li class="menu-item"><a href="{{ route('bko.call.index') }}">Liste des aides ouvertes</a></li>
                <li class="menu-item"><a href="{{ route('bko.call.indexClosed') }}">Liste des aides clôturées</a></li>
                <li class="menu-item"><a href="{{ route('bko.call.create') }}">Ajouter une aide</a></li>
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
                <li class="menu-item"><a href="{{ route('bko.subthematic.create') }}">Ajouter une sous-thématique</a>
                </li>
                @yield('menu-item-subthematic')
            </ul>
        </div>
        <div class="menu-category">
            <h5 class="category-title">Financeurs des aides</h5>
            <ul class="menu">
                <li class="menu-item"><a href="{{ route('bko.porteur-dispositif.index') }}">Liste des financeurs</a></li>
                <li class="menu-item"><a href="{{ route('bko.porteur-dispositif.create') }}">Ajouter un financeur</a></li>
                @yield('menu-item-projectHolder')
            </ul>
        </div>
        <div class="menu-category">
            <h5 class="category-title">Votre localisation</h5>
            <ul class="menu">
                <li class="menu-item"><a href="{{ route('bko.perimetre.index') }}">Liste des localisations</a></li>
                <li class="menu-item"><a href="{{ route('bko.perimetre.create') }}">Ajouter une localisation</a></li>
                @yield('menu-item-perimeter')
            </ul>
        </div>
        <div class="menu-category">
            <h5 class="category-title">Vous êtes ?</h5>
            <ul class="menu">
                <li class="menu-item"><a href="{{ route('bko.beneficiaire.index') }}">Liste des bénéficiaires</a></li>
                <li class="menu-item"><a href="{{ route('bko.beneficiaire.create') }}">Ajouter un bénéficiaire</a></li>
                @yield('menu-item-beneficiary')
            </ul>
        </div>
        <div class="menu-category">
            <h5 class="category-title">Sites de recensement</h5>
            <ul class="menu">
                <li class="menu-item"><a href="{{ route('bko.site.index') }}">Liste des sites</a></li>
                <li class="menu-item"><a href="{{ route('bko.site.create') }}">Ajouter un site</a></li>
                @yield('menu-item-website')
            </ul>
        </div>
        {{--<div class="menu-category">--}}
        {{--<h5 class="category-title">Organisations</h5>--}}
        {{--<ul class="menu">--}}
        {{--<li class="menu-item"><a href="{{ route('bko.structure.index') }}">Liste des organisations</a></li>--}}
        {{--<li class="menu-item"><a href="{{ route('bko.structure.create') }}">Ajouter une organisation</a></li>--}}
        {{--@yield('menu-item-organizationType')--}}
        {{--</ul>--}}
        {{--</div>--}}

        <div class="menu-category">
            <h5 class="category-title">Newsletter</h5>
            <ul class="menu">
                <li class="menu-item"><a href="{{ route('bko.subscriber.index') }}">Liste des abonnés</a></li>
                <li class="menu-item"><a href="{{ route('bko.subscriber.create') }}">Ajouter un abonné</a></li>
                @yield('menu-item-newsletter')
            </ul>
        </div>

        @admin
        <div class="menu-category">
            <h5 class="category-title">Utilisateurs</h5>
            <ul class="menu">
                <li class="menu-item"><a href="{{ route('bko.utilisateur.index') }}">Liste des utilisateurs</a></li>
                <li class="menu-item"><a href="{{ route('bko.utilisateur.create') }}">Ajouter un utilisateur</a></li>
                @yield('menu-item-user')
            </ul>
        </div>
        @endadmin
    </div>
</div>